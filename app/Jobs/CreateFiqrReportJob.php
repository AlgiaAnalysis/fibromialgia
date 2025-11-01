<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Http\Controllers\dao\GenericCtrl;
use App\Models\PatientReport;
use App\Models\PatientDomainReport;

class CreateFiqrReportJob implements ShouldQueue
{
    use Queueable;

    protected $patient;

    /**
     * Create a new job instance.
     */
    public function __construct($patient)
    {
        $this->patient = $patient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Check if patient already has an active FIQR report for the current period
        $mondayThisWeek = date('Y-m-d', strtotime('monday this week'));
        $sundayThisWeek = date('Y-m-d', strtotime('sunday this week'));
        
        // Check for any overlapping report period
        $activeReport = PatientReport::where('patient_pat_id', $this->patient->pat_id)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->where(function($query) use ($mondayThisWeek, $sundayThisWeek) {
                $query->whereBetween('par_period_starts', [$mondayThisWeek, $sundayThisWeek])
                      ->orWhereBetween('par_period_end', [$mondayThisWeek, $sundayThisWeek])
                      ->orWhere(function($q) use ($mondayThisWeek, $sundayThisWeek) {
                          $q->where('par_period_starts', '<=', $mondayThisWeek)
                            ->where('par_period_end', '>=', $sundayThisWeek);
                      });
            })
            ->first();
        
        // If an active report exists, don't create a new one
        if ($activeReport) {
            return;
        }
        
        // Get the last FIQR report to calculate the next period
        $lastPatientReport = PatientReport::where('patient_pat_id', $this->patient->pat_id)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->orderBy('par_period_starts', 'desc')
            ->first();
        
        // Calculate the next period
        if ($lastPatientReport) {
            // Start from the next Monday after the last report's end date
            $nextMonday = date('Y-m-d', strtotime('next monday', strtotime($lastPatientReport->par_period_end)));
            $nextSunday = date('Y-m-d', strtotime('sunday', strtotime($nextMonday)));
        } else {
            // If no previous report exists, start from this week
            $nextMonday = $mondayThisWeek;
            $nextSunday = $sundayThisWeek;
        }
        
        // Create the new PatientReport
        $patientReport = PatientReport::create([
            'par_period_starts' => $nextMonday,
            'par_period_end' => $nextSunday,
            'par_status' => PatientReport::STATUS_PENDING,
            'par_medication' => '',
            'par_score' => 0,
            'par_cli_resume' => '',
            'par_type' => PatientReport::TYPE_FIQR,
            'patient_pat_id' => $this->patient->pat_id,
        ]);
    
        // Days of the week
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    
        // Domains
        $domains = [
            PatientDomainReport::DOMAIN_FIRST,
            PatientDomainReport::DOMAIN_SECOND,
            PatientDomainReport::DOMAIN_THIRD
        ];
    
        // Create PatientDomainReports for each domain and each day
        foreach ($domains as $domain) {
            foreach ($weekDays as $weekday) {
                PatientDomainReport::create([
                    'pdr_domain' => $domain,
                    'pdr_score' => 0,
                    'pdr_weekday' => $weekday,
                    'patient_report_par_id' => $patientReport->par_id,
                ]);
            }
        }
    }
}

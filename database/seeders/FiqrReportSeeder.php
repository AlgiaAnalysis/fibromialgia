<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PatientReport;
use App\Models\PatientDomainReport;

class FiqrReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hard-coded patient ID
        $patientId = 1;

        // Create a FIQR report for the current week
        $mondayThisWeek = date('Y-m-d', strtotime('monday this week'));
        $sundayThisWeek = date('Y-m-d', strtotime('sunday this week'));

        $patientReport = PatientReport::create([
            'par_period_starts' => $mondayThisWeek,
            'par_period_end' => $sundayThisWeek,
            'par_status' => PatientReport::STATUS_PENDING,
            'par_medication' => '',
            'par_score' => 0,
            'par_cli_resume' => '',
            'par_type' => PatientReport::TYPE_FIQR,
            'patient_pat_id' => $patientId,
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

        $this->command->info("FIQR Report created for patient ID {$patientId} for week {$mondayThisWeek} to {$sundayThisWeek}");
    }
}

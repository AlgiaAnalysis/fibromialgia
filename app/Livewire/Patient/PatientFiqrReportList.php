<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientReport;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.patient-layout')]
class PatientFiqrReportList extends Component
{
    public function viewReportDay($reportId, $weekday) {
        return redirect()->route('patient.fiqr-report-form', ['id' => $reportId, 'weekday' => $weekday]);
    }

    public function render()
    {
        $patientId = Auth::user()->usr_represented_agent;
        
        // Get latest FIQR report for this patient (should be current week's report)
        $currentFiqrReport = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->with('patientDomainReports.reportAnswers')
            ->orderBy('par_period_starts', 'desc')
            ->first();

        // Get latest 10 FIQR reports for history
        $fiqrReports = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->orderBy('par_period_starts', 'desc')
            ->limit(10)
            ->get();

        // Days of the week
        $weekDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        // Check which days are filled
        $dayStatuses = [];
        foreach ($weekDays as $day) {
            $dayStatuses[$day] = false;
        }
        
        if ($currentFiqrReport && $currentFiqrReport->patientDomainReports) {
            foreach ($weekDays as $day) {
                // Check if all 3 domains have answers for this day
                $domainCount = 0;
                foreach ($currentFiqrReport->patientDomainReports as $domainReport) {
                    if ($domainReport->pdr_weekday === $day && $domainReport->reportAnswers && $domainReport->reportAnswers->count() > 0) {
                        $domainCount++;
                    }
                }
                // All 3 domains should have answers
                $dayStatuses[$day] = $domainCount === 3;
            }
        }

        return view('livewire.patient.patient-fiqr-report-list', [
            'fiqrReports' => $fiqrReports,
            'currentFiqrReport' => $currentFiqrReport,
            'weekDays' => $weekDays,
            'dayStatuses' => $dayStatuses
        ]);
    }
}

<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientReport;

#[Layout('components.layouts.patient-layout')]
class PatientDailyReportList extends Component
{
    public function redirectToDailyReportForm() {
        return redirect()->route('patient.daily-report-form');
    }

    public function viewReport($reportId) {
        return redirect()->route('patient.daily-report-form', ['id' => $reportId]);
    }

    public function render()
    {
        // Hard-coded patient ID as requested
        $patientId = 1;
        $today = date('Y-m-d');
        
        // Check if patient already filled today's questionnaire
        $todayReport = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->whereDate('par_period_starts', $today)
            ->first();
        
        // Get latest 10 daily reports for this patient
        $dailyReports = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->orderBy('par_period_starts', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.patient.patient-daily-report-list', [
            'dailyReports' => $dailyReports,
            'todayReport' => $todayReport
        ]);
    }
}

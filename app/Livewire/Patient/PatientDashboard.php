<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PatientReport;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use App\View\Components\Layouts\PatientLayout;

#[Layout(PatientLayout::class)]
class PatientDashboard extends Component
{
    public function goToDailyReportList() {
        return redirect()->route('patient.daily-report');
    }

    public function goToFiqrReportList() {
        return redirect()->route('patient.fiqr-report');
    }

    public function goToAppointmentList() {
        return redirect()->route('patient.appointment-list');
    }

    public function render()
    {
        $patientId = Auth::user()->usr_represented_agent;

        // Count daily reports
        $dailyReportsCount = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_DAILY)
            ->count();

        // Count FIQR reports
        $fiqrReportsCount = PatientReport::where('patient_pat_id', $patientId)
            ->where('par_type', PatientReport::TYPE_FIQR)
            ->count();

        // Count appointments
        $appointmentsCount = Appointment::where('patient_pat_id', $patientId)
            ->count();

        return view('livewire.patient.patient-dashboard', [
            'dailyReportsCount' => $dailyReportsCount,
            'fiqrReportsCount' => $fiqrReportsCount,
            'appointmentsCount' => $appointmentsCount,
        ]);
    }
}

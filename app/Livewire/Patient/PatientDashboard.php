<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.patient-layout')]
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
        return view('livewire.patient.patient-dashboard');
    }
}

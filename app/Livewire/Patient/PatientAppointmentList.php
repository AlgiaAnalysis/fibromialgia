<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Traits\ReportsTrait;
use App\View\Components\Layouts\PatientLayout;

#[Layout(PatientLayout::class)]
class PatientAppointmentList extends Component
{
    use ReportsTrait;

    public function redirectToAppointmentForm() {
        return redirect()->route('patient.appointment-form');
    }

    public function viewAppointment($appointmentId) {
        return redirect()->route('patient.appointment-form', ['id' => $appointmentId]);
    }

    public function render()
    {
        return view('livewire.patient.patient-appointment-list', [
            'appointments' => $this->getLatestAppointments(),
            'todayAppointment' => $this->getTodayAppointment()
        ]);
    }
}

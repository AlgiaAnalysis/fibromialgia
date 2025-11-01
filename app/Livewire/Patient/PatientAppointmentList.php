<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.patient-layout')]
class PatientAppointmentList extends Component
{
    public function redirectToAppointmentForm() {
        return redirect()->route('patient.appointment-form');
    }

    public function viewAppointment($appointmentId) {
        return redirect()->route('patient.appointment-form', ['id' => $appointmentId]);
    }

    public function render()
    {
        $patientId = Auth::user()->usr_represented_agent;
        $today = date('Y-m-d');
        
        // Check if patient already filled today's appointment
        $todayAppointment = Appointment::where('patient_pat_id', $patientId)
            ->whereDate('app_date', $today)
            ->first();
        
        // Get latest 10 appointments for this patient
        $appointments = Appointment::where('patient_pat_id', $patientId)
            ->orderBy('app_date', 'desc')
            ->limit(10)
            ->get();

        return view('livewire.patient.patient-appointment-list', [
            'appointments' => $appointments,
            'todayAppointment' => $todayAppointment
        ]);
    }
}

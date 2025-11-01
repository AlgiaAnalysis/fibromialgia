<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\DoctorLayout;
use Illuminate\Support\Facades\Auth;
use App\Models\DoctorPatients;
use App\Models\PatientReport;

#[Layout(DoctorLayout::class)]
class DoctorDashboard extends Component
{
    public function goToLinkPatient() {
        return redirect()->route('doctor.link-patient');
    }

    public function render()
    {
        $doctorId = Auth::user()->usr_represented_agent;

        // Get linked patients IDs
        $linkedPatientsIds = DoctorPatients::where('doctor_doc_id', $doctorId)
            ->pluck('patient_pat_id')
            ->toArray();

        // Count linked patients
        $doctorPatientsCount = count($linkedPatientsIds);

        // Count questionnaires from linked patients
        $questionnairesCount = PatientReport::whereIn('patient_pat_id', $linkedPatientsIds)
            ->count();

        return view('livewire.doctor.doctor-dashboard', [
            'doctorPatientsCount' => $doctorPatientsCount,
            'questionnairesCount' => $questionnairesCount,
        ]);
    }
}

<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\DoctorLayout;
use App\Models\User;
use App\Models\Patient;
use App\Models\DoctorPatients;
use App\Models\PatientReport;
use Illuminate\Support\Facades\Auth;
use TallStackUi\Traits\Interactions;

#[Layout(DoctorLayout::class)]
class DoctorLinkPatient extends Component
{
    use Interactions;

    public $searchType = 'name'; // 'name' or 'cpf'
    public $searchQuery = '';
    public $searchResults = [];
    public $showResults = false;

    public function searchPatients() {
        if (empty($this->searchQuery)) {
            $this->toast()->error('Por favor, digite um termo de busca.')->send();
            return;
        }

        $doctorId = Auth::user()->usr_represented_agent;
        
        // Search based on type
        if ($this->searchType === 'name') {
            $users = User::where('usr_role', User::ROLE_PATIENT)
                ->where('usr_name', 'like', '%' . $this->searchQuery . '%')
                ->get();
        } else {
            $users = User::where('usr_role', User::ROLE_PATIENT)
                ->where('usr_cpf', 'like', '%' . $this->searchQuery . '%')
                ->get();
        }

        // Process results
        $this->searchResults = [];
        
        foreach ($users as $user) {
            // Check if patient is already linked to this doctor
            $isLinked = DoctorPatients::where('doctor_doc_id', $doctorId)
                ->where('patient_pat_id', $user->usr_represented_agent)
                ->exists();

            // Get patient's latest score
            $latestReport = PatientReport::where('patient_pat_id', $user->usr_represented_agent)
                ->where('par_type', PatientReport::TYPE_DAILY)
                ->orderBy('par_period_starts', 'desc')
                ->first();

            $this->searchResults[] = [
                'user_id' => $user->usr_id,
                'patient_id' => $user->usr_represented_agent,
                'name' => $user->usr_name,
                'cpf' => $user->usr_cpf,
                'email' => $user->usr_email,
                'score' => $latestReport ? $latestReport->par_score : 0,
                'is_linked' => $isLinked,
            ];
        }

        $this->showResults = true;
    }

    public function dialogLinkPatient($id) {
        $this->dialog()
        ->question('Tem certeza que deseja vincular este paciente?')
        ->confirm(text: "Vincular", method: "linkPatient", params: $id)
        ->cancel(text: "Cancelar", method: "cancelled")
        ->send();
    }

    public function cancelled($message) {
        $this->toast()->error('Cancelado', $message)->send();
    }

    public function linkPatient($patientId) {
        $doctorId = Auth::user()->usr_represented_agent;

        // Check if already linked
        $existingLink = DoctorPatients::where('doctor_doc_id', $doctorId)
            ->where('patient_pat_id', $patientId)
            ->exists();

        if ($existingLink) {
            $this->toast()->error('Este paciente já está vinculado a você.')->send();
            return;
        }

        // Create the link
        DoctorPatients::create([
            'doctor_doc_id' => $doctorId,
            'patient_pat_id' => $patientId,
        ]);

        $this->toast()->success('Paciente vinculado com sucesso!')->send();
        
        // Refresh search results to update the status
        $this->searchPatients();
    }

    public function render()
    {
        return view('livewire.doctor.doctor-link-patient');
    }
}

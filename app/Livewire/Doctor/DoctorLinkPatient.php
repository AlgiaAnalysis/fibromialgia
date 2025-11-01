<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\View\Components\Layouts\DoctorLayout;
use App\Http\Controllers\dao\GenericCtrl;
use App\Http\Controllers\Utils\TripleDES;
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
    
    // Patient registration form fields
    public $patient = [
        'name' => '',
        'email' => '',
        'password' => '',
        'gender' => '',
        'passwordConfirmation' => '',
    ];
    
    public $activeTab = 'search'; // 'search' or 'register'

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

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        // Reset form when switching to register tab
        if ($tab === 'register') {
            $this->resetPatientForm();
        }
    }

    public function resetPatientForm()
    {
        $this->patient = [
            'name' => '',
            'email' => '',
            'password' => '',
            'gender' => '',
            'passwordConfirmation' => '',
        ];
    }

    public function registerPatient()
    {
        // Validate password match
        if ($this->patient['password'] !== $this->patient['passwordConfirmation']) {
            $this->toast()->error('As senhas não coincidem.')->send();
            return;
        }

        // Validate required fields
        if (empty($this->patient['name']) || empty($this->patient['email']) ||
            empty($this->patient['password']) || empty($this->patient['gender'])) {
            $this->toast()->error('Por favor, preencha todos os campos obrigatórios.')->send();
            return;
        }

        // Check if email already exists
        $userCtrl = new GenericCtrl("User");
        $userExists = $userCtrl->getObjectByField('usr_email', $this->patient['email'], true, true);
        if ($userExists == 1) {
            $this->toast()->error('Email já cadastrado.')->send();
            return;
        }

        $doctorId = Auth::user()->usr_represented_agent;

        // Encrypt password
        $tripleDES = new TripleDES();
        $encryptedPassword = $tripleDES->encrypt($this->patient['password']);

        // Create Patient record
        $patientCtrl = new GenericCtrl("Patient");
        $patient = $patientCtrl->save([
            'pat_streak' => 0,
            'pat_gave_informed_diagnosis' => false,
            'pat_hundred_days' => false,
            'pat_two_hundred_days' => false,
            'pat_three_hundred_days' => false,
            'pat_gender' => $this->patient['gender'],
            'pat_disease_discover_date' => null,
            'pat_stopped_treatment' => null,
        ]);

        // Create User record
        $userCtrl->save([
            'usr_name' => $this->patient['name'],
            'usr_email' => $this->patient['email'],
            'usr_password' => $encryptedPassword,
            'usr_role' => User::ROLE_PATIENT,
            'usr_represented_agent' => $patient->pat_id,
            'usr_created_at' => date('Y-m-d'),
        ]);

        // Automatically link patient to doctor with confirmed status
        DoctorPatients::create([
            'doctor_doc_id' => $doctorId,
            'patient_pat_id' => $patient->pat_id,
            'dop_status' => DoctorPatients::STATUS_LINKED,
        ]);

        $this->toast()->success('Paciente cadastrado e vinculado com sucesso!')->send();
        
        // Store name for search before resetting
        $nameToSearch = $this->patient['name'];
        
        // Reset form
        $this->resetPatientForm();
        
        // Switch to search tab and search for the newly registered patient
        $this->activeTab = 'search';
        $this->searchQuery = $nameToSearch;
        $this->searchType = 'name';
        $this->searchPatients();
    }

    public function render()
    {
        return view('livewire.doctor.doctor-link-patient');
    }
}

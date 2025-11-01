<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Http\Controllers\dao\GenericCtrl;
use App\Http\Controllers\Utils\TripleDES;
use App\Models\User;
use TallStackUi\Traits\Interactions;

#[Layout('components.layouts.app')]
class PatientSignUp extends Component
{
    use Interactions;

    public $patient = array(
        'name' => '',
        'email' => '',
        'password' => '',
        'gender' => '',
        'passwordConfirmation' => '',
    );

    public string $error = '';
    public string $success = '';

    public function handleSubmit() {
        $userCtrl = new GenericCtrl("User");
        $patientCtrl = new GenericCtrl("Patient");

        $tripleDES = new TripleDES();
        $encryptedPassword = $tripleDES->encrypt($this->patient['password']);

        if($this->patient['password'] !== $this->patient['passwordConfirmation']) {
            $this->toast()->error('As senhas não coincidem.')->send();
            return;
        }

        $userExists = $userCtrl->getObjectByField('usr_email', $this->patient['email'], true, true);
        if($userExists == 1) {
            $this->toast()->error('Email já cadastrado.')->send();
            return;
        }

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

        $userCtrl->save([
            'usr_name' => $this->patient['name'],
            'usr_email' => $this->patient['email'],
            'usr_password' => $encryptedPassword,
            'usr_role' => User::ROLE_PATIENT,
            'usr_represented_agent' => $patient->pat_id,
            'usr_created_at' => date('Y-m-d'),
        ]);

        $this->toast()->success('Cadastro realizado com sucesso!')->send();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.patient-sign-up');
    }
}

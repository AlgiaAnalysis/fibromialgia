<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Http\Controllers\dao\GenericCtrl;
use App\Http\Controllers\Utils\TripleDES;
use App\Models\User;
use TallStackUi\Traits\Interactions;

#[Layout('components.layouts.app')]
class DoctorSignUp extends Component
{
    use Interactions;

    public $doctor = array(
        'name' => '',
        'email' => '',
        'password' => '',
        'passwordConfirmation' => '',
        'crm' => '',
    );

    public string $error = '';
    public string $success = '';

    public function handleSubmit() {
        $userCtrl = new GenericCtrl("User");
        $doctorCtrl = new GenericCtrl("Doctor");

        $tripleDES = new TripleDES();
        $encryptedPassword = $tripleDES->encrypt($this->doctor['password']);

        if($this->doctor['password'] !== $this->doctor['passwordConfirmation']) {
            $this->toast()->error('As senhas não coincidem.')->send();
            return;
        }

        $userExists = $userCtrl->getObjectByField('usr_email', $this->doctor['email'], true, true);
        if($userExists == 1) {
            $this->toast()->error('Email já cadastrado.')->send();
            return;
        }

        $doctor = $doctorCtrl->save([
            'doc_crm' => $this->doctor['crm'],
        ]);

        $userCtrl->save([
            'usr_name' => $this->doctor['name'],
            'usr_email' => $this->doctor['email'],
            'usr_password' => $encryptedPassword,
            'usr_role' => User::ROLE_DOCTOR,
            'usr_represented_agent' => $doctor->doc_id,
            'usr_created_at' => date('Y-m-d'),
        ]);

        $this->toast()->success('Cadastro realizado com sucesso!')->send();
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.doctor-sign-up');
    }
}

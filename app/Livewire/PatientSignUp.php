<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class PatientSignUp extends Component
{
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
        $this->validate([
            'patient.name' => 'required',
            'patient.email' => 'required|email',
            'patient.password' => 'required',
            'patient.gender' => 'required',
            'patient.passwordConfirmation' => 'required|same:patient.password',
        ]);

        $this->success = 'Cadastro realizado com sucesso!';
    }

    public function render()
    {
        return view('livewire.patient-sign-up');
    }
}

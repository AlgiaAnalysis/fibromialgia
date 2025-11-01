<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class DoctorSignUp extends Component
{
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
        $this->validate([
            'doctor.name' => 'required',
            'doctor.email' => 'required|email',
            'doctor.password' => 'required',
            'doctor.passwordConfirmation' => 'required|same:doctor.password',
            'doctor.crm' => 'required',
        ]);
    }

    public function render()
    {
        return view('livewire.auth.doctor-sign-up');
    }
}

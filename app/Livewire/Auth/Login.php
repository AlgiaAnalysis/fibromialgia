<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class Login extends Component
{
    public $email = '';
    public $password = '';

    public $error = '';
    public $success = '';

    public function handleSubmit() {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    }

    public function goToPatientSignUp() {
        return redirect()->route('patient-sign-up');
    }

    public function goToDoctorSignUp() {
        return redirect()->route('doctor-sign-up');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}

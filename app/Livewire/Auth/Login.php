<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Http\Controllers\dao\GenericCtrl;
use App\Http\Controllers\Utils\TripleDES;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

#[Layout('components.layouts.app')]
class Login extends Component
{
    use Interactions;

    public $email = '';
    public $password = '';

    public $error = '';
    public $success = '';

    public function handleSubmit() {
        $userCtrl = new GenericCtrl("User");
        $tripleDES = new TripleDES();

        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = $userCtrl->getObjectByField('usr_email', $this->email, true);
        if(!$user instanceof User) {
            $this->toast()->error('Email ou senha inválidos.')->send();
            return;
        }

        if($tripleDES->decrypt($user->usr_password) !== $this->password) {
            $this->toast()->error('Email ou senha inválidos.')->send();
            return;
        }

        Auth::login($user);

        if($user->usr_role == User::ROLE_PATIENT) {
            return redirect()->route('patient.dashboard');
        }
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

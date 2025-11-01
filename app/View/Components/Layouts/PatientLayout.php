<?php

namespace App\View\Components\Layouts;

use Illuminate\View\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PatientLayout extends Component
{
    public $user;

    public function __construct()
    {
        $this->user = Auth::user();

        if($this->user == null) {
            Auth::logout();
            redirect()->route('login')->send();
        }

        if (!$this->user || $this->user->usr_role !== User::ROLE_PATIENT) {
            Auth::logout();
            redirect()->route('login')->send();
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

    public function render(): View
    {
        return view('components.layouts.patient-layout', [
            'user' => $this->user
        ]);
    }
} 
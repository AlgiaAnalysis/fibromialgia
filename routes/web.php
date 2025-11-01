<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\Auth\PatientSignUp;
use App\Livewire\Auth\DoctorSignUp;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Auth;

//? Áreas de Guest
Route::get('/', LandingPage::class);
Route::get('/patient-sign-up', PatientSignUp::class)->name('patient-sign-up');
Route::get('/doctor-sign-up', DoctorSignUp::class)->name('doctor-sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/logout', function() {
    Auth::logout();
    return redirect()->route('login');
});

//? Áreas que exigem autenticação
Route::prefix('admin')->group(base_path('routes/admin.php'));
Route::prefix('patient')->group(base_path('routes/patient.php'));
Route::prefix('doctor')->group(base_path('routes/doctor.php'));
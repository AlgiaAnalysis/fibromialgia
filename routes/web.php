<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\PatientSignUp;
use App\Livewire\DoctorSignUp;

//? Áreas de Guest
Route::get('/', LandingPage::class);
Route::get('patient-sign-up', PatientSignUp::class);
Route::get('doctor-sign-up', DoctorSignUp::class);

//? Áreas que exigem autenticação
Route::prefix('admin')->group(base_path('routes/admin.php'));

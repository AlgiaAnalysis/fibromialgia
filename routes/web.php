<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\PatientSignUp;
use App\Livewire\DoctorSignUp;

Route::get('/', LandingPage::class);
Route::get('patient-sign-up', PatientSignUp::class);
Route::get('doctor-sign-up', DoctorSignUp::class);
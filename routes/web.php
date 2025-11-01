<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\LandingPage;
use App\Livewire\PatientSignUp;

Route::get('/', LandingPage::class);
Route::get('patient-sign-up', PatientSignUp::class);

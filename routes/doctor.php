<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Doctor\DoctorDashboard;
use App\Livewire\Doctor\DoctorLinkPatient;
use App\Livewire\Doctor\DoctorReportsList;

Route::get('/dashboard', DoctorDashboard::class)->name('doctor.dashboard');
Route::get('/link-patient', DoctorLinkPatient::class)->name('doctor.link-patient');
Route::get('/reports-list', DoctorReportsList::class)->name('doctor.reports-list');
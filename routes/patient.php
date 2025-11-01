<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Patient\PatientDashboard;
use App\Livewire\Patient\PatientDailyReportList;
use App\Livewire\Patient\PatientDailyReportForm;
use App\Livewire\Patient\PatientFiqrReportList;
use App\Livewire\Patient\PatientFiqrReportForm;

Route::get('/dashboard', PatientDashboard::class)->name('patient.dashboard');
Route::get('/daily-report', PatientDailyReportList::class)->name('patient.daily-report');
Route::get('/daily-report-form/{id?}', PatientDailyReportForm::class)->name('patient.daily-report-form');

Route::get('/fiqr-report', PatientFiqrReportList::class)->name('patient.fiqr-report');
Route::get('/fiqr-report-form/{id}/{weekday}', PatientFiqrReportForm::class)->name('patient.fiqr-report-form');
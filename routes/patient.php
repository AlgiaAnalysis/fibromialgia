<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Patient\PatientDashboard;
use App\Livewire\Patient\PatientDailyReportList;
use App\Livewire\Patient\PatientDailyReportForm;
use App\Livewire\Patient\PatientFiqrReportList;
use App\Livewire\Patient\PatientFiqrReportForm;
use App\Livewire\Patient\PatientAppointmentList;
use App\Livewire\Patient\PatientAppointmentForm;
use App\Livewire\Patient\PatientDoctorList;
use App\Livewire\Patient\PatientReportsScreen;

Route::get('/dashboard', PatientDashboard::class)->name('patient.dashboard');
Route::get('/daily-report', PatientDailyReportList::class)->name('patient.daily-report');
Route::get('/daily-report-form/{id?}', PatientDailyReportForm::class)->name('patient.daily-report-form');

Route::get('/fiqr-report', PatientFiqrReportList::class)->name('patient.fiqr-report');
Route::get('/fiqr-report-form/{id?}', PatientFiqrReportForm::class)->name('patient.fiqr-report-form');

Route::get('/appointment-list', PatientAppointmentList::class)->name('patient.appointment-list');
Route::get('/appointment-form/{id?}', PatientAppointmentForm::class)->name('patient.appointment-form');

Route::get('/patient-doctor-list', PatientDoctorList::class)->name('patient-doctor-list');
Route::get('/patient-reports-screen', PatientReportsScreen::class)->name('patient-reports-screen');
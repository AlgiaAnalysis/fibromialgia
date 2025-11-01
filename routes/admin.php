<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\AdminDashboard;

Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');

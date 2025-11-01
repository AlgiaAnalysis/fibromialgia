<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin-layout')]
class AdminDashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}

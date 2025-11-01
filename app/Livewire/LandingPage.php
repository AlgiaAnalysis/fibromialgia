<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.app')]
class LandingPage extends Component
{
    public $modal = false;

    public function showModal()
    {
        $this->modal = true;
    }

    public function hideModal()
    {
        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.landing-page');
    }
}

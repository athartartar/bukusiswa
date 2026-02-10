<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.dashboard');
    }
}
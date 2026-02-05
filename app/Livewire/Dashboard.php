<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    // Kita set layoutnya ke components.layouts.app
    #[Layout('components.layouts.app')] 
    public function render()
    {
        return view('livewire.dashboard');
    }
}
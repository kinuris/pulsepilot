<?php

namespace App\Livewire\Layout;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminNav extends Component
{
    public function logout() {
        Auth::logout();

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.layout.admin-nav');
    }
}

<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Login extends Component
{
    public $email;
    public $password;

    public function mount()
    {
        if (!Auth::check()) {
            return;
        }

        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->to(route('admin.home'));
        }

        return redirect(route('home'));
    }

    public function login()
    {
        $validator = Validator::make(['email' => $this->email, 'password' => $this->password], [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Invalid login details');
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            return back()->with('error', 'Invalid login details');
        }

        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->to('/admin');
        }

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.login');
    }
}

<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class SettingsView extends Component
{
    use WithFileUploads;

    public $profileImage;
    public string $name;
    public string $email;
    public string $password;
    public string $passwordConfirmation;

    public function mount() {
        $user = Auth::user();

        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile() {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'profileImage' => 'nullable|image|max:1024', // 1MB Max
        ]);

        $user = User::query()->find(Auth::user()->id);
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->profileImage) {
            $path = $this->profileImage->store('doctor', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        session()->flash('message:green', 'Profile updated successfully.');
    }

    public function render()
    {
        return view('livewire.settings-view');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}

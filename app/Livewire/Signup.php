<?php

namespace App\Livewire;

use App\Models\RegistrationKey;
use App\Models\RegistrationKeyUsage;
use App\Models\User;
use Livewire\Component;

class Signup extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $passwordConfirmation = '';
    public string $registrationKey = '';

    public function register() {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|same:passwordConfirmation',
            'registrationKey' => 'required|string|exists:registration_keys,key_string',
        ]);

        $key = RegistrationKey::query()->where('key_string', $this->registrationKey)->first();

        if ($key->usage) {
            $this->addError('registrationKey', 'This registration key has already been used.');
            
            return;
        }

        $user = new User();

        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);  
        $user->role = 'doctor';

        $user->save();

        $usage = new RegistrationKeyUsage();

        $usage->registration_key_id = $key->id;
        $usage->user_id = $user->id;

        $usage->save();

        session()->flash('message', 'Registration successful!');

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.signup');
    }
}

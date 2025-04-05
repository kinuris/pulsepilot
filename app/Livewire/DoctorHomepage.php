<?php

namespace App\Livewire;

use App\Models\Connection;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DoctorHomepage extends Component
{
    public $patients;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->to('/login');
        }

        $this->patients = Connection::query()
            ->where('user_id', '=', Auth::user()->id)
            ->get()
            ->map(fn ($connection) => $connection->patient);
    }

    public function viewPatient(Patient $patient) {
        $this->redirect(route('patients', ['s' => $patient->id]));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }


    public function render()
    {
        return view('livewire.doctor-homepage');
    }
}

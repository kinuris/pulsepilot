<?php

namespace App\Livewire;

use App\Models\Patient;
use App\Models\RegistrationKeyUsage;
use App\Models\User;
use Livewire\Component;

class AdminHomepage extends Component
{
    public function render()
    {
        $onlinePatients = Patient::query()
            ->get()
            ->filter(function ($patient) {
                return $patient->isOnline();
            });

        $onlineDoctors = User::query()
            ->get()
            ->filter(function ($doctor) {
                return $doctor->isOnline();
            });

        $keyUsage24h = RegistrationKeyUsage::query()
            ->where('created_at', '>=', now()->subDay())
            ->get();

        return view('livewire.admin-homepage')
            ->with('onlinePatients', $onlinePatients)
            ->with('onlineDoctors', $onlineDoctors)
            ->with('keyUsage24h', $keyUsage24h);
    }
}

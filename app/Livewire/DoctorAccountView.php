<?php

namespace App\Livewire;

use App\Models\DoctorSuspend;
use App\Models\User;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class DoctorAccountView extends Component
{
    use WithPagination;

    #[Url(as: 's')]
    public string $search = "";

    #[Url(as: 'f')]
    public string $filter = "all"; // all, active, suspended

    public function deleteDoctor(User $doctor)
    {
        $doctor->delete();

        session()->flash('message', 'Doctor account deleted successfully.');
        $this->dispatch('$refresh');
    }

    public function activateDoctor(User $doctor)
    {
        $suspension = DoctorSuspend::query()
            ->where('doctor_id', $doctor->id)
            ->first();

        if ($suspension) {
            $suspension->delete();
        }
    }

    public function suspendDoctor(User $doctor)
    {
        $suspension = new DoctorSuspend();

        $suspension->doctor_id = $doctor->id;

        $suspension->save();
    }

    public function render()
    {
        $doctors = User::query()
            ->where('role', 'doctor')
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $doctors = $doctors->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filter === 'active') {
            $doctors = $doctors->whereDoesntHave('suspended');
        } elseif ($this->filter === 'suspended') {
            $doctors = $doctors->whereHas('suspended');
        }

        $doctors = $doctors->with('suspended')
            ->paginate(5);

        return view('livewire.doctor-account-view')->with('doctors', $doctors);
    }
}

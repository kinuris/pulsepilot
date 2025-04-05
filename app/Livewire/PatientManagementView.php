<?php

namespace App\Livewire;

use App\Models\Connection;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PatientManagementView extends Component
{
    public string $search = "";
    public bool $isFocused = false;

    #[Computed]
    public function searchResults()
    {
        if (empty($this->search)) {
            return Patient::query()
                ->limit(6)
                ->get()
                ->filter(fn($patient) => !$patient->connections->contains('user_id', Auth::user()->id));
        }

        return Patient::query()
            ->where('first_name', 'like', '%' . $this->search . '%')
            ->orWhere('last_name', 'like', '%' . $this->search . '%')
            ->limit(6)
            ->get()
            ->filter(fn($patient) => !$patient->connections->contains('user_id', Auth::user()->id));
    }

    #[Computed]
    public function connectedPatients()
    {
        return Connection::with('patient')
            ->where('user_id', Auth::user()->id)
            ->get()
            ->map(fn($connection) => $connection->patient);
    }

    public function removePatient(Patient $patient)
    {
        Connection::where('user_id', Auth::user()->id)
            ->where('patient_id', $patient->id)
            ->delete();

        $this->unfocused();

        session()->flash('message:red', 'Patient removed successfully.');
    }

    public function addPatient(Patient $patient)
    {
        $connection = new Connection();

        $connection->user_id = Auth::user()->id;
        $connection->patient_id = $patient->id;

        $connection->save();

        $this->unfocused();

        session()->flash('message:green', 'Patient added successfully.');
    }

    public function focused()
    {
        $this->isFocused = true;
    }

    public function unfocused()
    {
        $this->isFocused = false;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.patient-management-view');
    }
}

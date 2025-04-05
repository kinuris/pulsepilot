<?php

namespace App\Livewire;

use App\Models\Connection;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;
use Livewire\Component;

class PatientView extends Component
{
    #[Url(as: 'q')]
    public string $search = "";

    public bool $isFocused = false;

    #[Url(as: 'a')]
    public string $activeTab = "summary";

    #[Url(as: 's')]
    public $internalPatientId = null;

    // public $selectedPatient = null;
    #[Computed]
    public function selectedPatient() {
        if ($this->internalPatientId === null) return null; 

        return Patient::query()->find($this->internalPatientId);
    }

    #[Computed]
    public function searchResults()
    {
        if (empty($this->search)) {
            $patients = Connection::query()
                ->where('user_id', '=', Auth::user()->id)
                ->limit(6)
                ->get()
                ->map(fn($conn) => $conn->patient);

            return $patients;
        }

        return Connection::query()
            ->whereRelation('patient', 'first_name', 'LIKE', '%' . $this->search . '%')
            ->orWhereRelation('patient', 'last_name', 'LIKE', '%' . $this->search . '%')
            ->orWhereRelation('patient', 'middle_name', 'LIKE', '%' . $this->search . '%')
            ->limit(6)
            ->get()
            ->map(fn($conn) => $conn->patient);
    }

    public function setSelectedPatient(Patient $patient)
    {
        $this->internalPatientId = $patient->id;
        $this->unfocused();
    }

    public function clearSelectedPatient()
    {
        // $this->selectedPatient = null;
        $this->internalPatientId = null;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function focused()
    {
        $this->isFocused = true;
    }

    public function unfocused()
    {
        $this->isFocused = false;
    }

    public function render()
    {
        return view('livewire.patient-view');
    }
}

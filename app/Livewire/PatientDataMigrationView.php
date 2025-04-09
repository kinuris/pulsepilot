<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;

class PatientDataMigrationView extends Component
{
    public string $search = "";

    public function deletePatient(Patient $patient)
    {
        $patient->connections()->delete();
        $patient->chatMessages()->delete();
        $patient->immunizations()->delete();
        $patient->pastConditions()->delete();
        $patient->bmiRecords()->delete();
        $patient->waterRecords()->delete();
        $patient->glucoseRecords()->delete();
        $patient->nutritionRecords()->delete();
        $patient->activityRecords()->delete();
        $patient->medicationRecords()->delete();
        $patient->labRequests()->delete();

        $this->dispatch('patientDeleted');

        $patient->delete();
    }

    public function render()
    {
        $patients = Patient::query()
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $patients = $patients->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->search . '%')
                    ->orWhere('middle_name', 'like', '%' . $this->search . '%')
                    ->orWhere('last_name', 'like', '%' . $this->search . '%');
            });
        }

        $patients = $patients->get();

        return view('livewire.patient-data-migration-view')
            ->with('patients', $patients);
    }
}

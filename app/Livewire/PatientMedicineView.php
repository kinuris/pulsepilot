<?php

namespace App\Livewire;

use App\Models\MedicationRecord;
use App\Models\Patient;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;
use Livewire\WithPagination;

class PatientMedicineView extends Component
{
    use WithPagination;

    #[Reactive]
    public Patient $patient;

    #[Computed]
    public function medicationRecords()
    {
        return $this->patient->medicationRecords()->orderBy('medication_reminder_date', 'asc');
    }

    #[Computed]
    public function medicationRecordsPaginated()
    {
        return MedicationRecord::whereIn('id', $this->medicationRecords()->pluck('id'))->orderBy('medication_reminder_date', 'asc')->paginate();
    }

    #[Computed]
    public function latestRecord()
    {
        return $this->medicationRecords->first();
    }

    public function render()
    {
        return view('livewire.patient-medicine-view');
    }
}

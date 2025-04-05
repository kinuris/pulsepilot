<?php

namespace App\Livewire;

use App\Models\GlucoseRecord;
use App\Models\Patient;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\WithPagination;

class PatientGlucoseView extends Component
{
    use WithPagination;

    #[Reactive]
    public Patient $patient;

    #[Session]
    public string $unit = 'mmol';

    #[Computed]
    public function glucoseRecords()
    {
        return $this->patient->glucoseRecords()->orderBy('recorded_at', 'desc');
    }

    #[Computed]
    public function glucoseRecordsPaginated()
    {
        return GlucoseRecord::whereIn('id', $this->glucoseRecords()->pluck('id'))->orderBy('recorded_at', 'desc')->paginate();
    }

    #[Computed]
    public function latestRecord()
    {
        return $this->glucoseRecords->first();
    }

    public function render()
    {
        return view('livewire.patient-glucose-view');
    }
}

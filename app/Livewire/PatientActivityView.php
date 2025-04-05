<?php

namespace App\Livewire;

use App\Models\ActivityRecord;
use App\Models\Patient;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PatientActivityView extends Component
{
    #[Reactive]
    public Patient $patient;

    #[Computed()]
    public function activityRecords()
    {
        return $this->patient->activityRecords()->orderBy('recorded_at', 'desc');
    }

    #[Computed]
    public function activityRecordsPaginated()
    {
        return ActivityRecord::whereIn('id', $this->activityRecords()->pluck('id'))->orderBy('recorded_at', 'desc')->paginate();
    }

    #[Computed]
    public function latestRecord()
    {
        return $this->activityRecords->first();
    }

    public function render()
    {
        return view('livewire.patient-activity-view');
    }
}

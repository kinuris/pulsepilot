<?php

namespace App\Livewire;

use App\Models\NutritionRecord;
use App\Models\Patient;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PatientNutritionView extends Component
{
    #[Reactive]
    public Patient $patient;

    public $isLoading = true;

    #[Computed]
    public function nutritionRecords()
    {
        return $this->patient->nutritionRecords()->orderBy('recorded_at', 'desc');
    }

    #[Computed]
    public function nutritionRecordsPaginated()
    {
        return NutritionRecord::whereIn('id', $this->nutritionRecords()->pluck('id'))->orderBy('recorded_at', 'desc')->paginate();
    }

    #[Computed]
    public function latestRecord()
    {
        return $this->nutritionRecords->first();
    }

    public function render()
    {
        return view('livewire.patient-nutrition-view');
    }
}

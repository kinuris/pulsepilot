<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PatientSummaryView extends Component
{
    #[Reactive]
    public $patient;

    public function render()
    {
        return view('livewire.patient-summary-view');
    }
}

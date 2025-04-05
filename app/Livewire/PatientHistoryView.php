<?php

namespace App\Livewire;

use App\Models\ImmunizationHistory;
use App\Models\PastConditionHistory;
use Livewire\Attributes\Reactive;
use App\Models\Patient;
use Livewire\Component;

class PatientHistoryView extends Component
{
    public bool $creatingImmunization = false;
    public bool $creatingPastCondition = false;

    public bool $editImmunization = false;
    public bool $editPastCondition = false;

    public $selectedPastCondition = null;
    public $selectedImmunization = null;

    public $pastCondition = [
        'condition_name' => '',
        'condition_type' => '',
        'diagnosis_date' => '',
        'status' => '',
        'notes' => '',
    ];

    public $immunization = [
        'vaccine_name' => '',
        'administration_date' => '',
        'dose_number' => null,
        'manufacturer' => null,
        'notes' => null,
    ];

    #[Reactive]
    public Patient $patient;

    public function updatePastCondition() {
        $this->validate(
            [
                'selectedPastCondition.condition_name' => 'required',
                'selectedPastCondition.condition_type' => 'required',
                'selectedPastCondition.diagnosis_date' => 'required',
                'selectedPastCondition.status' => 'required',
            ],
            [
                'selectedPastCondition.condition_name.required' => 'The condition name is required.',
                'selectedPastCondition.condition_type.required' => 'The condition type is required.',
                'selectedPastCondition.diagnosis_date.required' => 'The diagnosis date is required.',
                'selectedPastCondition.status.required' => 'The status is required.',
            ]
        );

        $pastConditionInstance = PastConditionHistory::query()->find($this->selectedPastCondition['id']);

        $pastConditionInstance->condition_name = $this->selectedPastCondition['condition_name'];
        $pastConditionInstance->condition_type = $this->selectedPastCondition['condition_type'];
        $pastConditionInstance->diagnosis_date = $this->selectedPastCondition['diagnosis_date'];
        $pastConditionInstance->status = $this->selectedPastCondition['status'];
        $pastConditionInstance->notes = $this->selectedPastCondition['notes'];

        $pastConditionInstance->save();

        $this->editPastCondition = false;
    }

    public function updateImmunization() {
        $this->validate(
            [
                'selectedImmunization.vaccine_name' => 'required',
                'selectedImmunization.administration_date' => 'required',
            ],
            [
                'selectedImmunization.vaccine_name.required' => 'The vaccine name is required.',
                'selectedImmunization.administration_date.required' => 'The administration date is required.',
            ]
        );

        $immunizationInstance = ImmunizationHistory::query()->find($this->selectedImmunization['id']);

        $immunizationInstance->vaccine_name = $this->selectedImmunization['vaccine_name'];
        $immunizationInstance->administration_date = $this->selectedImmunization['administration_date'];
        $immunizationInstance->dose_number = $this->selectedImmunization['dose_number'];
        $immunizationInstance->manufacturer = $this->selectedImmunization['manufacturer'];
        $immunizationInstance->notes = $this->selectedImmunization['notes'];

        $immunizationInstance->save();

        $this->editImmunization = false;
    }

    public function saveImmunization()
    {
        $this->validate(
            [
                'immunization.vaccine_name' => 'required',
                'immunization.administration_date' => 'required',
            ],
            [
                'immunization.vaccine_name.required' => 'The vaccine name is required.',
                'immunization.administration_date.required' => 'The administration date is required.',
            ]
        );

        $immunization = new ImmunizationHistory();

        $immunization->patient_id = $this->patient->id;
        $immunization->vaccine_name = $this->immunization['vaccine_name'];
        $immunization->administration_date = $this->immunization['administration_date'];
        $immunization->dose_number = $this->immunization['dose_number'];
        $immunization->manufacturer = $this->immunization['manufacturer'];
        $immunization->notes = $this->immunization['notes'];

        $immunization->save();

        $this->creatingImmunization = false;
    }

    public function savePastCondition()
    {
        $this->validate(
            [
                'pastCondition.condition_name' => 'required',
                'pastCondition.condition_type' => 'required',
                'pastCondition.diagnosis_date' => 'required',
                'pastCondition.status' => 'required',
            ],
            [
                'pastCondition.condition_name.required' => 'The condition name is required.',
                'pastCondition.condition_type.required' => 'The condition type is required.',
                'pastCondition.diagnosis_date.required' => 'The diagnosis date is required.',
                'pastCondition.status.required' => 'The status is required.',
            ]
        );

        $pastCondition = new PastConditionHistory();

        $pastCondition->patient_id = $this->patient->id;
        $pastCondition->condition_name = $this->pastCondition['condition_name'];
        $pastCondition->condition_type = $this->pastCondition['condition_type'];
        $pastCondition->diagnosis_date = $this->pastCondition['diagnosis_date'];
        $pastCondition->status = $this->pastCondition['status'];
        $pastCondition->notes = $this->pastCondition['notes'];

        $pastCondition->save();

        $this->creatingPastCondition = false;
    }

    public function render()
    {
        return view('livewire.patient-history-view');
    }
}

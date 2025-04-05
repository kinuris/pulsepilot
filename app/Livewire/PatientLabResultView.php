<?php

namespace App\Livewire;

use App\Models\LabRequest;
use App\Models\LabSubmission;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class PatientLabResultView extends Component
{
    public string|null $testType = null;
    public string|null $priorityLevel = null;
    public string|null $clinicalIndication = null;

    public int|null $labRequestId = null;

    public bool $fastingRequired = false;

    #[Reactive]
    public Patient $patient;

    public bool $createModal = false;

    #[Computed]
    public function labRequest()
    {
        return LabRequest::query()
            ->where('id', $this->labRequestId)
            ->first();
    }

    #[Computed]
    public function labResult()
    {
        return LabSubmission::query()
            ->where('lab_request_id', $this->labRequestId)
            ->first();
    }

    public function closeLabResult()
    {
        $this->labRequestId = null;
    }

    public function submitLabRequest()
    {
        $this->validate([
            'testType' => 'required',
            'priorityLevel' => 'required',
            'clinicalIndication' => 'required',
        ]);

        $labRequest = new LabRequest();

        $labRequest->type = $this->testType;
        $labRequest->patient_id = $this->patient->id;
        $labRequest->priority_level = $this->priorityLevel;
        $labRequest->user_id = Auth::user()->id;
        $labRequest->clinical_indication = $this->clinicalIndication;
        $labRequest->fasting_required = $this->fastingRequired;

        $labRequest->save();

        // Close the modal after submission
        $this->createModal = false;

        // Reset form fields
        $this->reset(['testType', 'priorityLevel', 'clinicalIndication', 'fastingRequired']);

        // Optional: Show success message
        session()->flash('message', 'Lab request submitted successfully.');
    }

    public function render()
    {
        return view('livewire.patient-lab-result-view');
    }
}

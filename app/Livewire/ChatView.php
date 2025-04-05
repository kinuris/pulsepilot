<?php

namespace App\Livewire;

use App\Models\ChatMessage;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ChatView extends Component
{
    use WithFileUploads;

    public int|null $selectedPatientId = null;
    public int|null $lastMessageId = null;

    public $attachment;

    public int $messageCount = 10;
    public string $message = '';

    public Collection $messageThread;

    public function mount()
    {
        if ($this->selectedPatientId === null) {
            return;
        }

        $this->messageThread = ChatMessage::historyOf(Patient::query()->find($this->selectedPatientId), Auth::user(), $this->messageCount);
        $this->lastMessageId = $this->messageThread->last()?->id;
    }

    #[On('loadMore')]
    public function loadMore()
    {
        if ($this->selectedPatientId === null) {
            return;
        }

        $this->messageThread = ChatMessage::historyOf(Patient::query()->find($this->selectedPatientId), Auth::user(), $this->messageCount += 10) ?? new Collection();
        $this->dispatch('indirection');
    }

    #[On('indirection')]
    public function indirection()
    {
        $this->dispatch('messagesLoaded');
    }

    public function refreshMessage()
    {
        if ($this->selectedPatientId === null) {
            return;
        }

        $this->messageThread = ChatMessage::historyOf(Patient::query()->find($this->selectedPatientId), Auth::user(), $this->messageCount)  ?? new Collection();

        if ($this->lastMessageId !== $this->messageThread->last()?->id) {
            $this->lastMessageId = $this->messageThread->last()?->id;

            $this->dispatch('newMessage');
        }
    }

    public function setSelectedPatient($patient = null)
    {
        $this->dispatch('reinitializeChat');

        if ($patient !== null) {
            $patient = Patient::query()->find($patient);
            $this->selectedPatientId = $patient->id;
            $this->messageCount = 10;
            $this->messageThread = ChatMessage::historyOf($patient, Auth::user(), 10) ?? new Collection();
            $this->lastMessageId = $this->messageThread->last()?->id;
            $this->dispatch('toBottomIndirection');
        } else {
            $this->selectedPatientId = null;
            $this->lastMessageId = null;
            $this->messageThread = new Collection();
            $this->messageCount = 10;
        }
    }

    #[On('toBottomIndirection')]
    public function toBottomIndirection()
    {
        $this->dispatch('toBottom');
    }

    public function sendMessage()
    {
        if ($this->message === '') {
            return;
        }

        if ($this->attachment !== null) {
            $this->attachment->storePublicly('attachments', 'public');

            $message = new ChatMessage();

            $message->sender_type = 'doctor';
            $message->message_type = $this->attachment->getClientOriginalExtension() == 'pdf' ? 'pdf' : 'image';
            $message->path = $this->attachment->hashName();
            $message->patient_id = $this->selectedPatientId;
            $message->user_id = Auth::user()->id;

            $message->save();

            $this->attachment = null;
        }

        $message = new ChatMessage();

        $message->sender_type = 'doctor';
        $message->message_type = 'text';
        $message->message = $this->message;
        $message->patient_id = $this->selectedPatientId;
        $message->user_id = Auth::user()->id;

        $message->save();

        $this->message = '';
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.chat-view', [
            'selectedPatient' => $this->selectedPatientId ? Patient::query()->find($this->selectedPatientId) : null,
        ]);
    }
}

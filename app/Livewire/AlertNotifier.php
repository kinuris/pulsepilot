<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AlertNotifier extends Component
{
    public function render()
    {
        return view('livewire.alert-notifier');
    }

    public function handleLabAlert($key) {
        $alert = Cache::get($key);

        Cache::forget($key);

        return redirect('/patients?s=' . $alert['lab_submission']->labRequest->patient->id . '&a=labResults');
    }

    public function handleChatAlert($key)
    {
        $alert = Cache::get($key);

        Cache::forget($key);

        return redirect('/chat?p=' . $alert['from']->id);
    }

    public function cacheOnline()
    {
        $expiresAt = now()->addMinutes(2);
        Cache::put('online-' . Auth::user()->id, true, $expiresAt);
    }
}

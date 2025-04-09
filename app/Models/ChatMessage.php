<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ChatMessage extends Model
{
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function historyOf(Patient $patient, User $user, int $limit = 20)
    {
        $query = ChatMessage::query()
            ->where('patient_id', $patient->id)
            ->where('user_id', $user->id);

        if ($query->count() === 0) {
            return null;
        }

        return $query
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->reverse();
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($message) {
            if ($message->sender_type === 'doctor') {
                return;
            }

            $key = 'msgalert-' . $message->doctor->id . '-' . $message->patient->id;

            // Forget the old cache
            Cache::forget($key);

            // Store the new cache
            Cache::forever($key, [
                'key' => $key,
                'message_id' => $message->id,
                'from' => $message->patient,
                'message' => $message->message,
                'created_at' => $message->created_at,
            ]);

            // Maintain a list of keys
            $allKeys = Cache::get('msgalert-keys-' . $message->doctor->id, []);
            if (!in_array($key, $allKeys)) {
                $allKeys[] = $key;
                Cache::forever('msgalert-keys-' . $message->doctor->id, $allKeys);
            }
        });
    }
}

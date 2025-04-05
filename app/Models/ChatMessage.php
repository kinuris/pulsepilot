<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}

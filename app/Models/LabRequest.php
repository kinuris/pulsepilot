<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function labSubmission()
    {
        return $this->hasOne(LabSubmission::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

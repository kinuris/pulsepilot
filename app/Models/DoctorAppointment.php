<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAppointment extends Model
{
    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

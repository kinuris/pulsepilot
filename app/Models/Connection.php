<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    public static function getPatientsOfDoctor($doctorId)
    {
        return self::where('user_id', $doctorId)
            ->with('patient')
            ->get();
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

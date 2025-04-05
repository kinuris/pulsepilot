<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImmunizationHistory extends Model
{
    public function type()
    {
        return "Immunization";
    }

    public function name()
    {
        return $this->vaccine_name;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

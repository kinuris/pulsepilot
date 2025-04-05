<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastConditionHistory extends Model
{
    public function type()
    {
        return "Past Condition";
    }

    public function name()
    {
        return $this->condition_name;
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

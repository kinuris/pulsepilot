<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BmiRecord extends Model
{
    public function getBmiValueAttribute()
    {
        return $this->weight / ($this->height * $this->height);
    }
}

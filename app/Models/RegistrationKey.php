<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationKey extends Model
{
    public function usage()
    {
        return $this->hasOne(RegistrationKeyUsage::class);
    }
}

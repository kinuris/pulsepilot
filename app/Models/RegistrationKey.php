<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationKey extends Model
{
    public function usage()
    {
        return $this->hasOne(RegistrationKeyUsage::class);
    }

    public function usedBy()
    {
        return $this->hasOneThrough(
            User::class,
            RegistrationKeyUsage::class,
            'registration_key_id',
            'id',
            'id',
            'user_id'
        );
    }
}

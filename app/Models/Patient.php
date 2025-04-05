<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function connections()
    {
        return $this->hasMany(Connection::class);
    }

    public function immunizations()
    {
        return $this->hasMany(ImmunizationHistory::class);
    }

    public function pastConditions()
    {
        return $this->hasMany(PastConditionHistory::class);
    }

    public function glucoseRecords()
    {
        return $this->hasMany(GlucoseRecord::class);
    }

    public function nutritionRecords()
    {
        return $this->hasMany(NutritionRecord::class);
    }

    public function activityRecords()
    {
        return $this->hasMany(ActivityRecord::class);
    }

    public function medicationRecords()
    {
        return $this->hasMany(MedicationRecord::class);
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getAddressAttribute()
    {
        return implode(', ', array_filter([
            $this->province,
            $this->municipality,
            $this->barangay,
        ]));
    }

    public function getAgeAttribute()
    {
        $birthDate = date_create($this->birthdate);
        $today = date_create(date('Y-m-d'));
        $diff = date_diff($birthDate, $today);

        return $diff->y;
    }

    public static function genUniqueRecoveryId()
    {
        do {
            $recoveryId = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::where('recovery_id', $recoveryId)->exists());

        return $recoveryId;
    }
}

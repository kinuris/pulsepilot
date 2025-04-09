<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Patient extends Model
{
    public function isOnline()
    {
        $key = 'patient-online-' . $this->id;

        return Cache::has($key);
    }

    public function lastOnline()
    {
        $key = 'most-recent-patient-online-' . $this->id;

        return Cache::get($key);
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }

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

    public function bmiRecords()
    {
        return $this->hasMany(BmiRecord::class);
    }

    public function waterRecords()
    {
        return $this->hasMany(WaterRecord::class);
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

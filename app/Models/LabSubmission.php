<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class LabSubmission extends Model
{
    public function labRequest()
    {
        return $this->belongsTo(LabRequest::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($labSubmission) {
            $key = 'labalert-' . $labSubmission->lab_request_id;

            // Forget the old cache
            Cache::forget($key);

            // Store the new cache
            Cache::forever($key, [
                'key' => $key,
                'lab_submission' => $labSubmission,
                'type' => $labSubmission->type,
                'created_at' => $labSubmission->created_at,
            ]);

            // Maintain a list of keys
            $allKeys = Cache::get('labalert-keys', []);
            if (!in_array($key, $allKeys)) {
                $allKeys[] = $key;
                Cache::forever('labalert-keys', $allKeys);
            }
        });
    }
}

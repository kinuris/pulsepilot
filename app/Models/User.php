<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public function patients()
    {
        return Connection::query()
            ->where('user_id', '=', Auth::user()->id)
            ->get()
            ->map(fn($q) => $q->patient);
    }

    public function isOnline()
    {
        return Cache::has('online-' . $this->id);
    }

    public function suspended()
    {
        return $this->hasOne(DoctorSuspend::class, 'doctor_id');
    }

    public function msgAlerts()
    {
        $userId = $this->id;
        $keys = Cache::get('msgalert-keys-' . Auth::user()->id, []);

        return collect($keys)
            ->filter(fn($key) => str_contains($key, 'msgalert-' . $userId))
            ->map(fn($key) => Cache::get($key));
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

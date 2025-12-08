<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Counselor extends Authenticatable
{
    use Notifiable, HasFactory;

    protected $fillable = [
        // Authentication fields
        'name',
        'email',
        'password',
        'profile_image',

        // Counselor data
        'occupation',
        'specialties',
        'years_of_experience',
        'languages',
        'rating',
        'description',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'rating' => 'decimal:2',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

      public function availabilities()
    {
        return $this->hasMany(CounselorAvailability::class);
    }
}

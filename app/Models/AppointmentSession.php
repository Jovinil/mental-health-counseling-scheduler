<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSession extends Model
{
      protected $fillable = [
        'title',
        'duration',
        'description',
        'price',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

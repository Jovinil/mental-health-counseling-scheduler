<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'counselor_id',
        'appointment_session_id',
        'appointment_type',
        'session_date',
        'session_time',
        'notes',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }

    public function appointmentSession()
    {
        return $this->belongsTo(AppointmentSession::class);
    }


}

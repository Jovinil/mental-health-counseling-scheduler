<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselorAvailability extends Model
{
    protected $fillable = [
        'counselor_id',
        'day_of_week',
        'timeslot',
    ];

    public function counselor()
    {
        return $this->belongsTo(Counselor::class);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Counselor;
use App\Models\AppointmentSession;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $counselors = Counselor::all();
        $sessions = AppointmentSession::all();

        foreach (range(1, 10) as $i) {
            Appointment::create([
                'user_id' => $users->random()->id,
                'counselor_id' => $counselors->random()->id,
                'appointment_session_id' => $sessions->random()->id,

                'session_date' => now()->addDays(rand(1, 30))->format('Y-m-d'),
                'session_time' => collect(['08:00:00','09:00:00','13:30:00','15:00:00'])->random(),


                'notes' => 'Sample notes for appointment #' . $i,
                'status' => collect(['pending','finished','cancelled','rescheduled'])->random(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppointmentSession;

class AppointmentSessionSeeder extends Seeder
{
    public function run(): void
    {
        $sessions = [
            [
                'title' => 'Initial Consultation',
                'duration' => 60,
                'price' => 1000,
            ],
            [
                'title' => 'Follow-up Session',
                'duration' => 45,
                'price' => 800,
            ],
            [
                'title' => 'Crisis Intervention',
                'duration' => 30,
                'price' => 1200,
            ],
        ];

        foreach ($sessions as $session) {
            AppointmentSession::create($session);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counselor;
use App\Models\CounselorAvailability;

class CounselorAvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Days and times should match how you query:
        // - day_of_week: "Monday", "Tuesday", etc.
        // - timeslot: the same string you expect in the frontend
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // You can tweak these to your liking
        $timeSlots = [
            '09:00 AM',
            '10:00 AM',
            '02:00 PM',
            '03:00 PM',
        ];

        // Clear old availability if you want a clean slate
        // (comment this out if you don't want to truncate)
        CounselorAvailability::truncate();

        // For every counselor, seed availability for each weekday + slot
        Counselor::all()->each(function (Counselor $counselor) use ($days, $timeSlots) {
            foreach ($days as $day) {
                foreach ($timeSlots as $slot) {
                    CounselorAvailability::create([
                        'counselor_id' => $counselor->id,
                        'day_of_week'  => $day,
                        'timeslot'     => $slot,
                    ]);
                }
            }
        });
    }
}

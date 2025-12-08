<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Counselor;

class CounselorSeeder extends Seeder
{
    public function run(): void
    {
        $counselors = [
            [
                'name' => 'Dr. Jane Smith',
                'email' => 'counselor@gmail.com',
                'password' => bcrypt('password'), // default password
                'profile_image' => 'default.jpg',
                'occupation' => 'Licensed Clinical Psychologist',
                'specialties' => 'CBT, Anxiety, Depression',
                'years_of_experience' => 15,
                'languages' => 'English, Spanish',
                'rating' => 4.9,
                'description' => 'Specializes in CBT and helping patients with anxiety & depression.',
            ],
            [
                'name' => 'Dr. Michael Reyes',
                'email' => 'michael@example.com',
                'password' => bcrypt('password123'),
                'profile_image' => 'default.jpg',
                'occupation' => 'Psychotherapist',
                'specialties' => 'Trauma, PTSD, Mindfulness Therapy',
                'years_of_experience' => 10,
                'languages' => 'English, Filipino',
                'rating' => 4.7,
                'description' => 'Provides trauma-informed therapy and mindfulness coaching.',
            ],
            [
                'name' => 'Dr. Anna Lee',
                'email' => 'anna@example.com',
                'password' => bcrypt('password123'),
                'profile_image' => 'default.jpg',
                'occupation' => 'Licensed Psychiatrist',
                'specialties' => 'Medication Management, Bipolar, ADHD',
                'years_of_experience' => 12,
                'languages' => 'English, Korean',
                'rating' => 4.8,
                'description' => 'Experienced psychiatrist offering holistic mental wellness treatment.',
            ],
        ];

        foreach ($counselors as $counselor) {
            Counselor::create($counselor);
        }
    }
}

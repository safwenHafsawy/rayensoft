<?php

namespace Database\Seeders;

use App\Models\ExternalMeeting;
use App\Models\Leads;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $leads = Leads::all();

        if ($leads->isEmpty()) {
            $this->command->warn('No leads found, skipping MeetingSeeder.');
            return;
        }

        $meetings = [];

        for ($i = 0; $i < 30; $i++) {
            $meetings[] = [
                'title' => $faker->randomElement(['Initial Consultation', 'Project Discovery', 'Design Review', 'Contract Discussion', 'Follow-up']),
                'date' => $faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
                'hour' => $faker->time('H:i:s'),
                'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled']),
                'link' => $faker->randomElement(['https://zoom.us/j/123456789', 'https://meet.google.com/abc-defg-hij', null]),
                'lead_id' => $leads->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        ExternalMeeting::query()->insert($meetings);
    }
}

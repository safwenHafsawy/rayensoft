<?php

namespace Database\Seeders;

use App\Models\Leads;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::first();

        $leads = [];

        for ($i = 0; $i < 20; $i++) {
            $leads[] = [
                'id' => (string) Str::uuid(),
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'phone' => $faker->phoneNumber(),
                'status' => $faker->randomElement([
                    'New',
                    'Call Back',
                    'Call Back Requested',
                    'Inquiry',
                    'Processing',
                    'Proposition Sent',
                    'Not Interested',
                    'Won',
                    'Junk'
                ]),
                'industry' => $faker->randomElement(['Website : E-Commerce', 'Website : Services', 'Media Buyer', 'Consultation']),
                'lead_reason' => $faker->randomElement(['New Website', 'SEO', 'Mobile App', 'Marketing', 'Consulting']),
                'lead_source' => $faker->randomElement(['Booking Page', 'Referrals', 'Website', 'Email', 'Social Media', 'Direct Outreach']),
                'follow_up_date' => $faker->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
                'notes' => $faker->paragraph(),
                'found_by_id' => $user ? $user->id : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Leads::query()->insert($leads);
    }
}

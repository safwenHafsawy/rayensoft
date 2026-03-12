<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $applications = [];

        for ($i = 0; $i < 10; $i++) {
            $applications[] = [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'application_date'=> $faker->dateTimeBetween('-2 month', 'now'),
                'job_title' => $faker->randomElement(['Developer', 'Designer', 'Manager', 'Accountant']),
                'resume' => $faker->text(200),
                'cover_letter' => $faker->text(500),
                'status' => $faker->randomElement(['pending', 'reviewed', 'interviewed', 'hired', 'rejected']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('job_applications')->insert($applications);
    }
}


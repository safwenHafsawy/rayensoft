<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $messages = [];

        for ($i = 0; $i < 15; $i++) {
            $messages[] = [
                'id' => (string) Str::uuid(),
                'fullname' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'subject' => $faker->sentence(),
                'message' => $faker->paragraphs(3, true),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Message::query()->insert($messages);
    }
}

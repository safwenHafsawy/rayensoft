<?php

namespace Database\Seeders;

use App\Models\BankBalance;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class BankBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $balances = [];

        for ($i = 0; $i < 12; $i++) {
            $balances[] = [
                'amount' => $faker->randomFloat(2, 5000, 50000),
                'recorded_at' => $faker->dateTimeThisYear()->format('Y-m-d'),
                'notes' => $faker->optional()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        BankBalance::query()->insert($balances);
    }
}

<?php

namespace Database\Seeders;

use App\Models\FinancialTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class FinancialTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $transactions = [];

        for ($i = 0; $i < 50; $i++) {
            $transactions[] = [
                'id' => (string) Str::uuid(),
                'type' => $faker->randomElement(['income', 'expense']),
                'amount' => $faker->numberBetween(10000, 1000000), // In millimes (assumed)
                'category' => $faker->randomElement(['Hosting', 'Freelance', 'Marketing', 'Office', 'Software', 'Traveling', 'Consulting']),
                'date' => $faker->dateTimeThisYear()->format('Y-m-d'),
                'notes' => $faker->sentence(),
                'method' => $faker->randomElement(['cash', 'D17', 'transfer']),
            ];
        }

        FinancialTransaction::query()->insert($transactions);
    }
}

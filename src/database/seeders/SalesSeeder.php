<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Carbon\Carbon;

class SalesSeeder extends Seeder
{
    public function run()
    {
        // Initialize Faker
        $faker = Faker::create();

        // Generate sample data
        $sales = [];

        // Get Client and project IDs List from Database
        $clients = DB::table('clients')->pluck('id')->toArray();
        $projects = DB::table('projects')->pluck('id')->toArray();

        // Assuming you have clients and projects already, generate data accordingly
        for ($i = 0; $i < 10; $i++) {
            $sales[] = [
                'id' => (string) Str::uuid(),
                'client_id' => $faker->randomElement($clients), // Use actual client UUIDs if needed
                'project_id' => $faker->randomElement($projects), // Use actual project UUIDs if needed
                'amount' => $faker->randomFloat(2, 500, 5000), // Random amount between 500 and 5000
                'status' => $faker->randomElement(['Completed', 'Pending', 'Cancelled']),
                'sale_date' => $faker->dateTimeThisYear(),
                'offer' => $faker->word(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data into the sales table
        DB::table('sales')->insert($sales);
    }
}


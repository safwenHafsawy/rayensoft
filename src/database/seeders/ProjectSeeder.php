<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Project;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $today = Carbon::now();
        $endOfTheYear = Carbon::now()->endOfYear();

        // Get Client IDs List from Database
        $clients = DB::table('clients')->pluck('id')->toArray();

        $project = [];

        for($i = 0; $i < 10; $i++) {
            $project[] = [
                'id' => (string) Str::uuid(),
                'name' => $faker->word(),
                'description' => $faker->paragraph(),
                'client_id' => $faker->randomElement($clients),
                'phase' => $faker->randomElement(['Discovery', 'Design', 'Development', 'Testing', 'Deployment']),
                'start_date' => $faker->dateTimeThisYear(),
                'status' => $faker->randomElement(['Pending', 'In Progress', 'Completed']),
                'plan' => $faker->randomElement(['Basic', 'Standard', 'Premium', 'Custom']),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Project::query()->insert($project);
    }
}


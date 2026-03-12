<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class VisitorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This method seeds the 'visitors' table with 50 fake records for testing or development purposes.
     *
     * @return void
     */
    public function run()
    {
        // Initialize Faker to generate random data
        $faker = Faker::create();
        
        // Loop to create 50 visitor records
        foreach (range(1, 50) as $index) {
            // Generate a random date and time for when the visitor visited the site
            $visitedAt = $faker->dateTimeThisYear(); // e.g., '2024-05-17 14:45:00'
            
            // Generate a random date and time for the duration of the visit, this value can be null
            // The 'optional()' method is used to make this field optional
            $visitDuration = $faker->optional()->dateTimeThisYear(); // e.g., '2024-05-17 15:00:00' or null

            // Insert a new record into the 'visitors' table
            DB::table('visitors')->insert([
                // Generate a unique UUID for the 'id' field
                // UUIDs are used here to uniquely identify each visitor record
                'id' => (string) Str::uuid(), // e.g., 'd9b2d63b-1f63-4d7e-91a2-bd58d4c1d12b'
                
                // Generate a random IPv4 address for the 'ip_address' field
                // This simulates the IP address of the visitor
                'ip_address' => $faker->ipv4, // e.g., '192.168.1.1'
                
                // Generate a random session ID for the 'session_id' field
                // Session IDs typically identify user sessions, though this is randomly generated here
                'session_id' => Str::random(40), // e.g., 'f6c4f9f83b2c4b4c9c8c7d6e5b6c4e7a8d2b3e4f5g6h7i8j9k0l1m2n3o4p5q6r7s'
                
                // Generate a random user agent string for the 'user_agent' field
                // This simulates the browser or device used by the visitor
                'user_agent' => $faker->userAgent, // e.g., 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
                
                // Generate a random city name for the 'location' field
                // This simulates the geographic location of the visitor
                'location' => $faker->city, // e.g., 'San Francisco'
                
                // Generate a random number between 1 and 10 for the 'visited_pages_count' field
                // This simulates the number of pages the visitor viewed during their session
                'visited_pages_count' => $faker->numberBetween(1, 10), // e.g., 5
                
                // Generate a random URL for the 'last_page' field, this value can be null
                // The 'optional()' method is used to make this field optional
                'last_page' => $faker->optional()->url, // e.g., 'https://example.com/page/5' or null
                
                // Format the 'visited_at' datetime to 'YYYY-MM-DD' for the 'visited_at' field
                // This ensures that this field is always non-null
                'visited_at' => $visitedAt->format('Y-m-d'), // e.g., '2024-05-17'
                
                // Format the 'visit_duration' datetime to 'YYYY-MM-DD' if it's not null
                // Otherwise, set the field to null
                // This allows for tracking the duration of the visit or having a null value if no duration is available
                'visit_duration' => $visitDuration ? $visitDuration->format('Y-m-d') : null, // e.g., '2024-05-17' or null
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ClientSeeder extends Seeder
{
    /**
     * Define countries and their cities.
     *
     * @var array
     */
    private $countriesAndCities = [
        'Tunisia' => ['Tunis', 'Sfax', 'Sousse', 'Kairouan', 'Bizerte'],
        'Libya' => ['Tripoli', 'Benghazi', 'Misrata', 'Sebha', 'Zliten'],
        'Egypt' => ['Cairo', 'Alexandria', 'Giza', 'Shubra El Kheima', 'Port Said'],
        'Algeria' => ['Algiers', 'Oran', 'Constantine', 'Annaba', 'Blida'],
        'Jordan' => ['Amman', 'Zarqa', 'Irbid', 'Aqaba', 'Mafraq'],
        'Lebanon' => ['Beirut', 'Tripoli', 'Sidon', 'Tyre', 'Jounieh'],
        'Syria' => ['Damascus', 'Aleppo', 'Homs', 'Latakia', 'Deir ez-Zor'],
        'Iraq' => ['Baghdad', 'Basra', 'Mosul', 'Erbil', 'Kirkuk'],
        'Saudi Arabia' => ['Riyadh', 'Jeddah', 'Mecca', 'Medina', 'Dammam'],
        'United Arab Emirates' => ['Dubai', 'Abu Dhabi', 'Sharjah', 'Ajman', 'Ras Al Khaimah'],
    ];

    /**
     * Generate a random phone number for a given country.
     *
     * @param string $country
     * @return string
     */
    private function generatePhoneNumber(string $country): string
    {
        $faker = Faker::create();
        $countryCodes = [
            'Tunisia' => '216',
            'Libya' => '218',
            'Egypt' => '20',
            'Algeria' => '213',
            'Jordan' => '962',
            'Lebanon' => '961',
            'Syria' => '963',
            'Iraq' => '964',
            'Saudi Arabia' => '966',
            'United Arab Emirates' => '971',
        ];

        $countryCode = $countryCodes[$country] ?? '000'; // Default code if country is not found
        $operatorCode = $faker->randomNumber(2, true);
        $subscriberNumber = $faker->randomNumber(6, true);

        return '+' . $countryCode . ' ' . $operatorCode . ' ' . $subscriberNumber;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $leads = \App\Models\Leads::all();

        if ($leads->isEmpty()) {
            $this->command->warn('No leads found, skipping ClientSeeder.');
            return;
        }

        $clients = [];

        // Convert some leads to clients
        $selectedLeads = $leads->random(min(10, $leads->count()));

        foreach ($selectedLeads as $lead) {
            // Randomly select a country and a city from that country
            $country = $faker->randomElement(array_keys($this->countriesAndCities));
            $city = $faker->randomElement($this->countriesAndCities[$country]);

            $clients[] = [
                'id' => (string) Str::uuid(),
                'lead_id' => $lead->id,
                'country' =>  $country,
                'city' => $city,
                'address' => $faker->address(),
                'type' => $faker->randomElement(['New', 'Satisfied', 'Unsatisfied']),
                'engagement_date' => $faker->dateTimeThisYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Client::query()->insert($clients);
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'Safwen Hafsawy',
            'email' => 'safwenhafsawy@rayensoft.com',
            'password' => Hash::make('12345678'),
            'position' => 'CTO',
            'phone' => '51303002',
            'address' => '123 Main St',
            'dob' => '1999-01-01',
            'doh' => '2022-01-01',
            'employment_status' => 'partner',
            'gender' => 'Male',
            'photo' => fake()->url(),
            'telegram_chat_id' => 1901283043,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
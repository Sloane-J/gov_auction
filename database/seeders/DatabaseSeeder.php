<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default System Admin
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Default Auction Officer
        User::firstOrCreate(
            ['email' => 'officer@example.com'],
            [
                'name' => 'Officer User',
                'password' => Hash::make('password'),
                'role' => 'officer',
                'email_verified_at' => now(),
            ]
        );

        // Fixed Bidders for Easy Testing
        $fixedBidders = [
            ['name' => 'Bidder User', 'email' => 'bidder@example.com'],
            ['name' => 'Kwame Mensah', 'email' => 'kwame@example.com'],
            ['name' => 'Abena Osei', 'email' => 'abena@example.com'],
            ['name' => 'Kofi Boateng', 'email' => 'kofi@example.com'],
            ['name' => 'Ama Appiah', 'email' => 'ama@example.com'],
        ];

        foreach ($fixedBidders as $bidder) {
            User::firstOrCreate(
                ['email' => $bidder['email']],
                [
                    'name' => $bidder['name'],
                    'password' => Hash::make('password'),
                    'role' => 'bidder',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Additional Random Bidders via Factory
        User::factory(10)->create([
            'role' => 'bidder',
        ]);
    }
}

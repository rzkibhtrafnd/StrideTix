<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin StrideTix',
            'email' => 'admin@stridetix.com',
            'phone' => '081234567890',
            'role' => UserRole::ADMIN->value,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Surabaya Runners EO',
            'email' => 'organizer@stridetix.com',
            'phone' => '089876543210',
            'role' => UserRole::ORGANIZER->value,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'Jakarta Marathon EO',
            'email' => 'jkt.marathon@stridetix.com',
            'phone' => '081122334455',
            'role' => UserRole::ORGANIZER->value,
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
        ]);
    }
}
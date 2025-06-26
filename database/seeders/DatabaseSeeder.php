<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Demo',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'balance' => 1000000,
            'is_admin' => true,
        ]);

        // User
        User::create([
            'name' => 'User Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'balance' => 250000,
            'is_admin' => false,
        ]);
    }
}
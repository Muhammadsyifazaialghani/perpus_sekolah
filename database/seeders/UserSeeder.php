<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
            'role' => 'admin',
        ]);

        // Create normal user
        User::create([
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'password' => Hash::make('userpassword'),
            'role' => 'user',
        ]);
    }
}

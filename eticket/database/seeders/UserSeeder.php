<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun ADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'organizer_status' => 'berhasil' 
        ]);

        // 2. Akun ORGANIZER
        User::create([
            'name' => 'Event Organizer 1',
            'email' => 'organizer@test.com',
            'password' => Hash::make('organizer123'),
            'role' => 'organizer',
            'organizer_status' => 'berhasil' 
        ]);

        // 3. Akun USER BIASA
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@test.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'organizer_status' => 'berhasil' 
        ]);
    }
}
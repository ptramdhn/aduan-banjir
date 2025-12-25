<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin
        User::create([
            'name' => 'Admin Ganteng',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'no_hp' => '081234567890',
        ]);

        // 2. Akun Lurah
        User::create([
            'name' => 'Pak Lurah',
            'email' => 'lurah@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'lurah',
            'no_hp' => '089876543210',
        ]);

        // 3. Akun Warga
        User::create([
            'name' => 'Warga Biasa',
            'email' => 'warga@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'warga',
            'no_hp' => '081122334455',
        ]);
    }
}

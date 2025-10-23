<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::create([
            'name' => 'Admin LiteraSpace',
            'email' => 'admin@literaspace.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Akun Pengguna
        User::create([
            'name' => 'Pengguna Biasa',
            'email' => 'user@literaspace.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}

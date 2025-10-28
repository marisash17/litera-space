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
        User::updateOrCreate(
            ['email' => 'admin@literaspace.com'], // cek berdasarkan email
            [
                'name' => 'Admin LiteraSpace',
                'password' => Hash::make('password'), // reset password
                'role' => 'admin',
            ]
        );

        // Akun Pengguna
        User::updateOrCreate(
            ['email' => 'user@literaspace.com'], // cek berdasarkan email
            [
                'name' => 'Pengguna Biasa',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}

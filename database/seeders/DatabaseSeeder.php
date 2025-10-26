<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // User Admin saja dulu
    User::create([
        'name' => 'Admin LiteraSpace',
        'email' => 'admin@literaspace.com',
        'password' => Hash::make('admin123'),
        'is_admin' => true,
    ]);
    }
}
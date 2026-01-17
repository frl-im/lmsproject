<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ADMIN
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'is_admin' => 1,
            ]
        );

        // USER BIASA
        User::updateOrCreate(
            ['email' => 'user@email.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'),
                'is_admin' => 0,
            ]
        );
    }
}

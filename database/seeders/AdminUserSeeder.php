<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'olexto@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('Dhanushka13228'),
                'email_verified_at' => now(),
            ]
        );
    }
}



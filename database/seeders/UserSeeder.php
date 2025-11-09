<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@afikry.com',
            'password' => '$2y$12$8imLfueikiGKuquq6EXGMun4TKZvjbRb0T3ACjOjFYLCxMRE260ri', // password
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@afikry.com',
            'password' => '$2y$12$8imLfueikiGKuquq6EXGMun4TKZvjbRb0T3ACjOjFYLCxMRE260ri', // password
            'role' => 'cashier'
        ]);
    }
}
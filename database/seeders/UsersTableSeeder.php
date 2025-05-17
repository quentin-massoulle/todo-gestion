<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {

        User::create([
            'name' => 'quentin',
            'email' => 'quentin@mail.com',
            'is_admin' => true,
            'password' => bcrypt('password123')
        ]);

        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'is_admin' => false,
            'password' => bcrypt('password123')
        ]);

         User::create([
            'name' => 'jake Doe',
            'email' => 'jake@example.com',
            'is_admin' => false,
            'password' => bcrypt('password123')
        ]);

         User::create([
            'name' => 'louison Doe',
            'email' => 'louison@example.com',
            'is_admin' => false,
            'password' => bcrypt('password123')
        ]);
    }
}

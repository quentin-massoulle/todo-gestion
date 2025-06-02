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
            'nom' => 'Massoulle',
            'prenom' => 'Quentin',
            'email' => 'quentin@mail.com',
            'is_admin' => true,
            'password' => bcrypt('password123')
        ]);

        User::factory()->count(10)->create();
    }
}

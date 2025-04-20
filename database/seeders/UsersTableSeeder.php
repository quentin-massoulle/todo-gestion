<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Crée un utilisateur spécifique
        User::create([
            'name' => 'quentin',
            'email' => 'quentin@mail.com',
            'is_admin' => true,
            'password' => bcrypt('Tintindu800*')
        ]);

        // Ou plusieurs utilisateurs avec des valeurs personnalisées
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'is_admin' => false,
            'password' => bcrypt('password123')
        ]);
    }
}

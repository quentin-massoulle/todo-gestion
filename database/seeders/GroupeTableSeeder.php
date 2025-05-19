<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Groupe;
use App\Models\GroupeUser;
use App\Models\User;


class GroupeTableSeeder extends Seeder
{

    public function run(): void
    {
         // Créer entre 3 et 10 groupes
        $groupes = Groupe::factory()->count(rand(3, 10))->create();

        // Pour chaque groupe, associer entre 1 et 5 utilisateurs aléatoires
        foreach ($groupes as $groupe) {
            $userIds = User::inRandomOrder()->take(rand(2, 5))->pluck('id');
            $groupe->users()->attach($userIds);
        }
    }
}

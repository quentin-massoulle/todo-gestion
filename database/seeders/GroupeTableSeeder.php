<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Groupe;
use App\Models\GroupeUser;

class GroupeTableSeeder extends Seeder
{

    public function run(): void
    {
        Groupe::create([
            'name' => 'groupe numero 1',
        ]);
         Groupe::create([
            'name' => 'groupe numero 2',
        ]);


        GroupeUser::create([
            'groupe_id' => 1,
            'user_id' => 2,
        ]);
        GroupeUser::create([
            'groupe_id' => 1,
            'user_id' => 3,
        ]);

        GroupeUser::create([
            'groupe_id' => 2,
            'user_id' => 3,
        ]);
        GroupeUser::create([
            'groupe_id' => 2,
            'user_id' => 4,
        ]);
    }
}

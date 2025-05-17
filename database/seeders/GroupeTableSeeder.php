<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Groupe;
use App\Models\GroupeUser;

class GroupeTableSeeder extends Seeder
{

    public function run(): void
    {
        Groupe::create([
            'name' => 'groupe numero 1',
        ]);

        GroupeUser::create([
            'groupe_id' => 1,
            'user_id' => 1,
        ]);
        GroupeUser::create([
            'groupe_id' => 1,
            'user_id' => 2,
        ]);
    }
}

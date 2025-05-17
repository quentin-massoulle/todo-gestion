<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


use App\Models\Task;
class TacheTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
          
        Task::create([
            'titre' => 'tache 1',
            'description' => 'je suis la premier tache de groupe',
            'user_id' => 1,
            'groupe_id' => 1
        ]);
          
        Task::create([
            'titre' => 'tache 2',
            'description' => 'essayer de modifier la facon dont est penser le systeme de tache',
            'user_id' => 2,
            'groupe_id' => 1
        ]);
          
        Task::create([
            'titre' => 'tache 3',
            'description' => 'premier tache solo',
            'user_id' => 1,
        ]);
          
        Task::create([
            'titre' => 'tache 4 ',
            'description' => "tache d'un nouveau groupe",
            'user_id' => 3,
            'groupe_id' => 2,

        ]);
          
        Task::create([
            'titre' => 'tache 1',
            'description' => 'je suis la ',
            'user_id' => 4,
            'groupe_id' => 2
        ]);
          
        Task::create([
            'titre' => 'tache 6',
            'description' => 'je suis la mais sans plus',
            'user_id' => 1,
        ]);
    }
}

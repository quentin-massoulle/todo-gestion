<?php

namespace Database\Factories;
use App\Models\Task;
use App\Models\User;
use App\Models\Groupe;


use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // database/factories/TaskFactory.php

        return [
            'titre' => fake()->sentence(3), // titre court (ex: "Planifier réunion équipe")
            'description' => fake()->paragraph(2), // 2 phrases
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'groupe_id' => fake()->boolean(70) // 70% de chances d’avoir un groupe
                ? Groupe::inRandomOrder()->first()?->id
                : null,
            'etat' => fake()->randomElement(['nouveau', 'planifie', 'en_cours', 'termine']),
            'date_fin' => fake()->dateTimeBetween('now', '+1 month'), // Date de fin dans le futur
            'date_debut' => fake()->dateTimeBetween('-1 month', 'now'),// Date de début dans le passé ou le futur proche
        ];

    }
}

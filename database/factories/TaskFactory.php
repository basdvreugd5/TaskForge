<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Task;
use App\Models\Board;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Task::class;

    public function definition(): array
    {
        $status = $this->faker->boolean(50)
            ? 'open'
            : $this->faker->randomElement(['in_progress', 'done']);
        
         $priority = $this->faker->boolean(50)
            ? 'medium'
            : $this->faker->randomElement(['low', 'high']);
            
        return [
            'board_id' => Board::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'soft_due_date' => fake()->dateTimeThisMonth(),
            'hard_deadline' => fake()->dateTimeThisMonth(),
            'status' => $status,
            'priority' => $priority,

        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $hardDeadline = $this->faker->dateTimeThisMonth();

        return [
            'board_id' => Board::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'hard_deadline' => $hardDeadline,
            'soft_due_date' => $this->faker->dateTimeBetween('-1 month', $hardDeadline),
            'status' => $status,
            'priority' => $priority,

        ];
    }
}

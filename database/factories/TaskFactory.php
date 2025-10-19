<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            : $this->faker->randomElement(['in_progress', 'review', 'done']);

        $priority = $this->faker->boolean(50)
           ? 'medium'
           : $this->faker->randomElement(['low', 'high']);

        $hardDeadline = Carbon::instance($this->faker->dateTimeBetween('now', '+1 month'));

        return [
            'board_id' => Board::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'hard_deadline' => $hardDeadline,
            'soft_due_date' => Carbon::instance($this->faker->dateTimeBetween($hardDeadline->copy()->subDays(5), $hardDeadline)),
            'status' => $status,
            'priority' => $priority,
            'checklist' => collect(range(1, rand(2, 5)))->map(function () {
                return [
                    'title' => $this->faker->words(3, true),
                    'is_completed' => $this->faker->boolean(30),
                ];
            })->toArray(),
        ];
    }
}

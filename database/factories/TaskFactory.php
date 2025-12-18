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
        $hardDeadline = Carbon::instance(
            fake()->dateTimeBetween('now', '+1 month'),
        );

        return [
            'board_id' => Board::factory(),
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'hard_deadline' => $hardDeadline,
            'soft_due_date' => Carbon::instance(
                fake()->dateTimeBetween(
                    $hardDeadline->copy()->subDays(5),
                    $hardDeadline,
                ),
            ),
            'status' => fake()->randomElement(['open', 'in_progress', 'review', 'done']),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'checklist' => collect(range(1, rand(2, 5)))->map(fn() => [
                'title' => 'Checklist Item',
                'is_completed' => false,
            ])->toArray(),
        ];
    }
}

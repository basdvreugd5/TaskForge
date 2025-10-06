<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Board::class;

    public function definition(): array
    {
        return [
            'name' => fake()->sentence(2),
            'user_id' => User::factory(),
            'description' => fake()->paragraph(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Board $board) {
            $board->collaborators()->attach($board->user_id, ['role' => 'owner']);
        });
    }

    public function hasCollaborators(): static
    {
        return $this->afterCreating(function (Board $board) {

            $nonOwnerUsers = User::where('id', '!=', $board->user_id)->inRandomOrder()->limit(3)->get();

            if ($nonOwnerUsers->count() >= 1) {
                $board->collaborators()->attach($nonOwnerUsers->shift()->id, ['role' => 'editor']);
            }

            foreach ($nonOwnerUsers as $user) {
                $board->collaborators()->attach($user->id, ['role' => 'member']);
            }

        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Board;
use App\Models\Tag;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $testUser = User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@taskforge.test',
        ]);

        $users = User::factory(9)->create();

        $users->push($testUser);

        $users->each(function ($user) {
            Board::factory(3)
                ->for($user)
                ->has(Task::factory(10))
                ->create()
                ->each(function ($board) {
                    $tags = Tag::factory(5)->create();

                    $board->tasks->each(function ($task) use ($tags) {
                        $task->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray()
                    );
                });
            });
        });
    }
}

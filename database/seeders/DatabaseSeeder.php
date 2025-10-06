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

        $otherUsers = User::factory(9)->create();
        $allUsers = $otherUsers->push($testUser);

        $globalTags = Tag::factory(10)->create();

        $allUsers->each(function ($user) use ($allUsers, $globalTags) {
            Board::factory(2)
                ->for($user)
                ->has(Task::factory(10))
                ->create()
                ->each(function ($board) use ($globalTags) {
                    $this->attachTags($board, $globalTags);
                });

            $collaborationBoard = Board::factory()
                ->for($user)
                ->has(Task::factory(10))
                ->create([
                    'name' => "Collaboration Board by {$user->name}",
                ]);

            $potentialCollaborators = $allUsers->except($user->id)->shuffle();

            $editor = $potentialCollaborators->shift();
            if ($editor) {
                $collaborationBoard->collaborators()->attach($editor->id, ['role' => 'editor']);

            }

            $member1 = $potentialCollaborators->shift();
            $member2 = $potentialCollaborators->shift();
            if ($member1) {
                $collaborationBoard->collaborators()->attach($member1->id, ['role' => 'member']);
            }
            if ($member2) {
                $collaborationBoard->collaborators()->attach($member2->id, ['role' => 'member']);
            }

            $this->attachTags($collaborationBoard, $globalTags);
        });
    }

    protected function attachTags(Board $board, $tags) : void 
    {
        $board->tasks->each(function ($task) use ($tags) {
            $task->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());        
        });
    }
}

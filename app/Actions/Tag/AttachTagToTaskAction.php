<?php

namespace App\Actions\Tag;

use App\Models\Tag;
use App\Models\Task;

class AttachTagToTaskAction
{
    /**
     * Finds/creates the tag and attaches it to the task.
     */
    public function execute(Task $task, string $tagName): void
    {
        $tag = Tag::firstOrCreate(['name' => $tagName]);

        $task->tags()->syncWithoutDetaching([$tag->id]);
    }
}

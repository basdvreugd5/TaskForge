<?php

namespace App\Actions\Tag;

use App\Models\Tag;
use App\Models\Task;

class DetachTagFromTaskAction
{
    /**
     * Detaches the tag from the task.
     */
    public function execute(Task $task, Tag $tag): void
    {
        $task->tags()->detach($tag->id);
    }
}

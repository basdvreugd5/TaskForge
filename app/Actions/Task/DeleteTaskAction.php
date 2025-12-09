<?php

namespace App\Actions\Task;

use App\Models\Board;
use App\Models\Task;

class DeleteTaskAction
{
    /**
     * Delete a Task and return its parent board.
     */
    public function handle(Task $task): Board
    {
        $board = $task->board;

        $task->delete();

        return $board;

    }
}

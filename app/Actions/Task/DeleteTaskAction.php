<?php

namespace App\Actions\Task;

use App\Models\Board;
use App\Models\Task;

class DeleteTaskAction
{
    /**
     * Executes the logic to delete a Task and returns the parent Board.
     */
    public function execute(Task $task): Board
    {

        $board = $task->board;

        $task->delete();

        return $board;
    }
}

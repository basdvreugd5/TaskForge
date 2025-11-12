<?php

namespace App\Actions\Task;

use App\Models\Board;
use App\Models\Task;

class DeleteTaskAction
{
    /**
     * Delete a Task and return its parent board.
     *
     * @param  \App\Models\Task  $task
     * @return \App\Models\Board
     */
    public function execute(Task $task): Board
    {

        $board = $task->board;

        $task->delete();

        return $board;
    }
}

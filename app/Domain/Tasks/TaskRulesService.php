<?php

namespace App\Domain\Tasks;

use App\Models\Board;
use RuntimeException;

class TaskRulesService
{
    public function assertBoardTaskLimitNotReached(Board $board): void
    {
        if ($board->tasks()->count() >= 200) {
            throw new RuntimeException('Task limit reached for this board.');
        }
    }
}

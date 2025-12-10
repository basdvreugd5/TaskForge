<?php

namespace App\Actions\Task;

use App\Domain\Tasks\ChecklistService;
use App\Domain\Tasks\TaskDateService;
use App\Domain\Tasks\TaskRulesService;
use App\Models\Board;
use App\Models\Task;

class CreateTaskAction
{
    public function __construct(
        protected ChecklistService $checklists,
        protected TaskDateService $dates,
        protected TaskRulesService $rules,
    ) {}

    public function handle(Board $board, array $data): Task
    {
        $this->rules->assertBoardTaskLimitNotReached($board);

        $this->dates->validateDates(
            $data['soft_due_date'] ?? null,
            $data['hard_deadline'] ?? null,
        );

        $data['checklist'] = $this->checklists->process($data['checklist'] ?? []);

        $data['board_id'] = $board->id;

        return Task::create($data);
    }
}

<?php

namespace App\Actions\Task;

use App\Domain\Tasks\ChecklistService;
use App\Domain\Tasks\TaskDateService;
use App\Models\Task;

class UpdateTaskAction
{
    public function __construct(
        protected ChecklistService $checklists,
        protected TaskDateService $dates,
    ) {}
    /**
     *
     * Update an existing Task.
     */
    public function handle(Task $task, array $data): Task
    {
        $this->dates->validateDates(
            $data['soft_due_date'] ?? null,
            $data['hard_deadline'] ?? null,
        );

        if (array_key_exists('checklist', $data)) {
            $data['checklist'] = $this->checklists->process($data['checklist']);
        }

        $task->update($data);

        return $task;
    }
}

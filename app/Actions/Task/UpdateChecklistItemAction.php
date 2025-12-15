<?php

namespace App\Actions\Task;

use App\Domain\Tasks\ChecklistService;
use App\Models\Task;

class UpdateChecklistItemAction
{
    public function __construct(
        protected ChecklistService $checklists,
    ) {}
    /**
     *
     * Update an checklist item.
     */
    public function handle(Task $task, array $data): void
    {
        $checklist = $this->checklists->process($task->checklist);

        $checklist[$data['index']]['is_completed'] = $data['is_completed'];

        $task->update(['checklist' => $checklist]);
    }
}

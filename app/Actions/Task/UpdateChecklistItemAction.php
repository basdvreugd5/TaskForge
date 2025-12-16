<?php

namespace App\Actions\Task;

use App\Domain\Tasks\ChecklistService;
use App\Models\Task;
use RuntimeException;

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

        if (! array_key_exists($data['index'], $checklist)) {
            throw new RuntimeException('Invalid checklist item index.');
        }

        $checklist[$data['index']]['is_completed'] = $data['is_completed'];

        $task->update(['checklist' => $checklist]);
    }
}

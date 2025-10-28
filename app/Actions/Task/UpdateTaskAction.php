<?php

namespace App\Actions\Task;

use App\Models\Task;

class UpdateTaskAction
{
    /**
     * Executes the logic to update an existing Task.
     */
    public function execute(Task $task, array $data): Task
    {
        $updateData = array_merge($data, [
            'checklist' => collect($data['checklist'] ?? [])->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'is_completed' => $item['is_completed'] ?? false,
                ];
            })->toArray(),
        ]);

        $task->update($updateData);

        return $task;
    }
}

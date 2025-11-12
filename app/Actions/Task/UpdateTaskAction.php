<?php

namespace App\Actions\Task;

use App\Models\Task;

class UpdateTaskAction
{
    /**
     * Update an existing Task.
     *
     * @param  \App\Models\Task  $task
     * @param  array<string, mixed>  $data
     * @return \App\Models\Task
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

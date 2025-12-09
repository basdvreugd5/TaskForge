<?php

namespace App\Actions\Task;

use App\Models\Board;
use App\Models\Task;

class CreateTaskAction
{
    /**
     * Create a new Task.
     */
    public function execute(Board $board, array $data): Task
    {
        $taskData = array_merge($data, [
            'board_id' => $board->id,
            'checklist' => collect($data['checklist'] ?? [])->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'is_completed' => $item['is_completed'] ?? false,
                ];
            })->toArray(),
        ]);

        $task = Task::create($taskData);

        return $task;
    }
}

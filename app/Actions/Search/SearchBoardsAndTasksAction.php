<?php

namespace App\Actions\Search;

use App\Models\Board;
use App\Models\Task;

class SearchBoardsAndTasksAction
{
    public function handle(array $filters): array
    {
        $query = $filters['query'] ?? null;

        $boards = Board::query()
            ->when(
                $query,
                fn($q)
                => $q->where('name', 'like', "%{$query}%"),
            )
            ->with('user')
            ->get();

        $tasks = Task::query()
            ->when(
                $query,
                fn($q)
                => $q->where('title', 'like', "%{$query}%"),
            )
            ->with('board')
            ->get();

        return [
            'boards' => $boards,
            'tasks' => $tasks,
        ];
    }
}

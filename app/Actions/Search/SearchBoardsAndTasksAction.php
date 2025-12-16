<?php

namespace App\Actions\Search;

use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;

class SearchBoardsAndTasksAction
{
    protected BoardFilter $boardFilter;

    public function __construct(BoardFilter $boardFilter)
    {
        $this->boardFilter = $boardFilter;
    }

    public function handle(array $filters): array
    {
        $boards = $this->boardFilter
            ->apply(Board::query(), $filters)
            ->with('user')
            ->get();

        $tasksQuery = Task::query()
            ->whereIn('board_id', $boards->pluck('id'))
            ->when(!empty($filters['search']), function ($q) use ($filters) {
                $search = $filters['search'];
                $q->where(function ($qq) use ($search) {
                    $qq->where('title', 'like', "%{$search}%")
                       ->orWhereHas('board', fn($b) => $b->where('name', 'like', "%{$search}%"));
                });
            });

        $tasks = $tasksQuery
            ->with('board')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return [
            'boards' => $boards,
            'tasks' => $tasks,
            'filters' => $filters,
        ];
    }
}

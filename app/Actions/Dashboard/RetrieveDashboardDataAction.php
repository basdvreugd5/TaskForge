<?php

namespace App\Actions\Dashboard;

use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;

class RetrieveDashboardDataAction
{
    /**
     * Retrieve dashboard data based on filters.
     *
     * @param  mixed  $filters
     * @return array{boards: \Illuminate\Database\Eloquent\Collection<int, Board>, tasks: mixed}
     */
    public function execute($filters): array
    {
        $boards = (new BoardFilter)
            ->apply(Board::query(), $filters)
            ->with('user')
            ->withCount('tasks')
            ->withCount('collaborators')
            ->get();

        $boardIds = $boards->pluck('id')->toArray();

        $tasks = Task::whereIn('board_id', $boardIds)
            ->with('board')
            ->orderBy('hard_deadline', 'asc')
            ->paginate(5)
            ->withQueryString();

        return ['boards' => $boards, 'tasks' => $tasks];
    }
}

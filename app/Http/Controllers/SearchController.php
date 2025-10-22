<?php

namespace App\Http\Controllers;

use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search index
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Board::class);

        $filters = $request->only('search', 'type');

        $boards = (new BoardFilter)
            ->apply(Board::query(), $filters)
            ->where(function ($query) {})
            ->get();

        $boardIds = $boards->pluck('id')->toArray();

        $tasks = Task::whereIn('board_id', $boardIds)
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.index', compact('boards', 'tasks', 'filters'));
    }
}

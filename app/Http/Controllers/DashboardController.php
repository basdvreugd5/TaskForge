<?php

namespace App\Http\Controllers;

use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $filters = $request->only('search', 'type');
        $filters['type'] ??= 'owned';

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

        return view('dashboard.index', compact('user', 'boards', 'tasks', 'filters'));
    }
}

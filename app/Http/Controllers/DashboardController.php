<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard view.
     */
    public function index()
    {
        $user = Auth::user();

        $boards = $user->boards()
            ->with('user')
            ->withCount('tasks')
            ->withCount('collaborators')
            ->get();

        $tasks = Task::whereIn('board_id', $user->boards()->pluck('id'))
            ->with('board')
            ->orderBy('hard_deadline', 'asc')
            ->paginate(5);

        // Note: update this logic later to include tasks from collaborated boards!

        return view('dashboard.index', compact('user', 'boards', 'tasks'));
    }
}

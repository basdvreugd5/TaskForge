<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
        /**
     * Display the main dashboard view.
     */
    public function index()
    {
        $user = Auth::user();

        // Query for boards where the user is the creator (user_id)
        $boards = $user->boards()
                       ->with('user')            // Eager load the creator (the user)
                       ->withCount('tasks')      // Count the tasks on the board
                       ->withCount('collaborators') // Count collaborators for shared/owned logic
                       ->get();

        // Get tasks from all boards the user owns
        $tasks = Task::whereIn('board_id', $user->boards()->pluck('id'))
            ->with('board')
            ->orderBy('hard_deadline', 'asc')
            ->paginate(5);
            
        // Note: update this logic later to include tasks from collaborated boards!

        return view('dashboard.index', compact('user', 'boards', 'tasks'));
    }
}

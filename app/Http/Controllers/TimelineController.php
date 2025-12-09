<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    /**
     * Timeline view
     */
    public function index(): \Illuminate\View\View
    {
        $this->authorize('viewAny', Board::class);

        $boards = Board::with(['tasks' => function ($query) {
            $query->select('id', 'board_id', 'title', 'soft_due_date', 'hard_deadline', 'status', 'priority');
        }])
            ->where('user_id', Auth::id())
            ->get(['id', 'name', 'user_id']);

        return view('dashboard.timeline', compact('boards'));
    }
}

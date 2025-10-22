<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    /**
     * Timeline view
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $this->authorize('viewAny', \App\Models\Board::class);

        $boards = Board::with(['tasks' => function ($query) {
            $query->select('id', 'board_id', 'title', 'soft_due_date', 'hard_deadline', 'status', 'priority');
        }])
            ->where('user_id', Auth::id())
            ->get(['id', 'name', 'user_id']);

        return view('dashboard.timeline', compact('boards'));
    }
}

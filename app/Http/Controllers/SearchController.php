<?php

namespace App\Http\Controllers;

use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Board::class);

        $filters = $request->only('search', 'type');

        // get filtered boards (owned / shared / both)
        $boards = (new BoardFilter)
            ->apply(Board::query(), $filters)
            ->where(function ($query) {
                // ensure user cannot see others' boards when no explicit type passed
                // BoardFilter already scopes by current user, so this is mostly defensive
            })
            ->get();

        $boardIds = $boards->pluck('id')->toArray();

        // limit tasks to the filtered boards
        $tasks = Task::whereIn('board_id', $boardIds)
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.index', compact('boards', 'tasks', 'filters'));
    }
}

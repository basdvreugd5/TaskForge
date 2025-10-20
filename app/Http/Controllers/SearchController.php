<?php

namespace App\Http\Controllers;

use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', \App\Models\Board::class);

        $filters = $request->only('search');

        $boards = (new BoardFilter)->apply(Board::query()
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereHas('collaborators', function ($q) {
                        $q->where('user_id', Auth::id());
                    });
            }), $filters)
            ->get();

        $tasks = Task::when($filters['search'] ?? null, function ($query) use ($filters) {
            return $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['search'].'%')
                    ->orWhereHas('board', function ($query) use ($filters) {
                        $query->where('name', 'like', '%'.$filters['search'].'%')
                            ->where(function ($q) {
                                $q->where('user_id', Auth::id())
                                    ->orWhereHas('collaborators', function ($qq) {
                                        $qq->where('user_id', Auth::id());
                                    });
                            });
                    });
            });
        })->whereHas('board', function ($query) {
            $query->where(function ($q) {
                $q->where('user_id', Auth::id())
                    ->orWhereHas('collaborators', function ($qq) {
                        $qq->where('user_id', Auth::id());
                    });
            });
        })->paginate(10)->withQueryString();

        return view('dashboard.index', compact('boards', 'tasks', 'filters'));
    }
}

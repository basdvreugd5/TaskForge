<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    // Show
    public function show(Board $board)
    {
        $this->authorize('view', $board);

        $board->load(['tasks' => function ($query) {
            $query->whereIn('status', ['open', 'in_progress', 'review', 'done']);
        }]);

        return view('dashboard.boards.show', compact('board'));
    }

    // Create
    public function create()
    {
        return view('dashboard.boards.create', [
            'board' => new Board,
        ]);
    }

    // Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $board = Board::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'user_id' => Auth::id(),
        ]);

        $board->collaborators()->attach(Auth::id(), ['role' => 'owner']);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board created successfully!');
    }

    // Edit
    public function edit(Board $board)
    {
        $this->authorize('update', $board);

        return view('dashboard.boards.edit', compact('board'));
    }

    // Update
    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $board->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board updated successfully!');
    }

    // Destroy
    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);

        $board->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Board deleted successfully');
    }

    public function shared()
    {
        $user = Auth::user();

        $sharedBoards = $user->collaboratedBoards()
            ->wherePivot('role', '!=', 'owner')
            ->with(['user', 'tasks', 'collaborators'])
            ->withCount('collaborators')
            ->withCount('tasks')
            ->get();

        return view('dashboard.shared.index', compact('sharedBoards'));

    }

    public function manageCollaborators(Board $board)
    {
        return view('dashboard.boards.collaborators.manage', compact('board'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BoardController extends Controller
{
    /**
     * Authorize resource actions for Board model.
     */
    public function __construct()
    {
        $this->authorizeResource(Board::class, 'board');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Display the specified board along with its tasks.
     */
    public function show(Board $board)
    {
        // $this->authorize('view', $board);
        $board->load(['tasks' => function ($query) {
            $query->whereIn('status', ['open', 'in_progress', 'review', 'done']);
        }]);

        return view('dashboard.boards.show', compact('board'));
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Show the form for creating a new board.
     */
    public function create()
    {
        return view('dashboard.boards.create', [
            'board' => new Board,
        ]);
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Store a newly created board.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:10|max:255',
            'description' => 'nullable|string|min:20|max:1000',
        ]);

        DB::transaction(function () use ($validated, &$board) {
            $board = Board::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'user_id' => Auth::id(),
            ]);

            $board->collaborators()->syncWithoutDetaching([
                Auth::id() => ['role' => 'owner'],
            ]);
        });

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board created successfully!');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Show the form for editing the specified board.
     */
    public function edit(Board $board)
    {
        return view('dashboard.boards.edit', compact('board'));
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Update the specified board.
     */
    public function update(Request $request, Board $board): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|min:10|max:255',
            'description' => 'nullable|string|min:20|max:1000',
        ]);

        $board->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board updated successfully!');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Remove the specified board.
     */
    public function destroy(Board $board)
    {
        $board->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Board deleted successfully');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Show the collaborator management view for the specified board.
     */
    public function manageCollaborators(Board $board)
    {
        $this->authorize('addCollaborator', $board);

        return view('dashboard.boards.collaborators.manage', compact('board'));
    }
}

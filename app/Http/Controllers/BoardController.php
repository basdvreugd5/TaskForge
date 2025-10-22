<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\BoardUpdateRequest;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;
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
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Board $board)
    {
        $board->load(['tasks' => function ($query) {
            $query->whereIn('status', ['open', 'in_progress', 'review', 'done']);
        }]);

        return view('dashboard.boards.show', compact('board'));
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Show the form for creating a new board.
     *
     * @return \Illuminate\Contracts\View\View
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(BoardStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $board = DB::transaction(function () use ($validated) {
            $board = Board::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'user_id' => Auth::id(),
            ]);

            $board->collaborators()->syncWithoutDetaching([
                Auth::id() => ['role' => 'owner'],
            ]);

            return $board;
        });

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board created successfully!');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Show the form for editing the specified board.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Board $board)
    {
        return view('dashboard.boards.edit', compact('board'));
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Update the specified board.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(BoardUpdateRequest $request, Board $board): RedirectResponse
    {
        $validated = $request->validated();

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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Board $board): RedirectResponse
    {
        $board->delete();

        return redirect()->route('dashboard.index')
            ->with('success', 'Board deleted successfully');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Show the collaborator management view for the specified board.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function manageCollaborators(Board $board)
    {
        $this->authorize('addCollaborator', $board);

        return view('dashboard.boards.collaborators.manage', compact('board'));
    }
    // ------------------------------------------------------------------------------------------------------
}

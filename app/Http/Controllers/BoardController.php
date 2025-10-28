<?php

namespace App\Http\Controllers;

use App\Actions\Board\CreateBoardAction;
use App\Actions\Board\DeleteBoardAction;
use App\Actions\Board\UpdateBoardAction;
use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\BoardUpdateRequest;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;

class BoardController extends Controller
{
    /**
     * Authorize resource actions for Board model.
     */
    public function __construct()
    {
        $this->authorizeResource(Board::class, 'board');
    }
    // ----------------------------------------------------------

    /**
     * Display the specified board along with its tasks.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Board $board)
    {
        $board->loadActiveTasks();

        return view('dashboard.boards.show', compact('board'));
    }
    // ----------------------------------------------------------

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
    // ----------------------------------------------------------

    /**
     * Store a newly created board.
     *
     * @param  \App\Http\Requests\BoardStoreRequest  $request
     * @param  \App\Actions\Board\CreateBoardAction  $createBoardAction
     * @return \Illuminate\Http\RedirectResponse
     *
     * @phpstan-parm array<string, mixed> $validated
     *
     * @phpstan-return \Illuminate\Http\RedirectResponse
     */
    public function store(BoardStoreRequest $request, CreateBoardAction $createBoardAction): RedirectResponse
    {
        $validated = $request->validated();

        $board = $createBoardAction->execute($validated);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board created successfully!');
    }
    // ----------------------------------------------------------

    /**
     * Show the form for editing the specified board.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Board $board)
    {
        return view('dashboard.boards.edit', compact('board'));
    }
    // ----------------------------------------------------------

    /**
     * Update the specified board.
     *
     * @parm \App\Http\Requests\BoardUpdateRequest $request
     * @parm \App\Models\Board $board
     * @parm \App\Actions\Board\UpdateBoardAction $updateBoardAction
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @phpstan-parm array<string, mixed> $validated
     */
    public function update(BoardUpdateRequest $request, Board $board, UpdateBoardAction $updateBoardAction): RedirectResponse
    {
        $validated = $request->validated();

        $updateBoardAction->execute($board, $validated);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board updated successfully!');
    }
    // ----------------------------------------------------------

    /**
     * Remove the specified board.
     *
     * @param  \App\Models\Board  $board
     * @param  \App\Actions\Board\DeleteBoardAction  $deleteBoardAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Board $board, DeleteBoardAction $deleteBoardAction): RedirectResponse
    {
        $deleteBoardAction->execute($board);

        return redirect()->route('dashboard.index')
            ->with('success', 'Board deleted successfully');
    }
}

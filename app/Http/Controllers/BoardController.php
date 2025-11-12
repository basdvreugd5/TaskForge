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
     * @param  BoardStoreRequest  $request
     * @param  CreateBoardAction  $action
     *
     * @phpstan-param array<string, mixed> $validated
     *
     * @return RedirectResponse
     *
     * @phpstan-return \Illuminate\Http\RedirectResponse
     */
    public function store(BoardStoreRequest $request, CreateBoardAction $action): RedirectResponse
    {
        $validated = $request->validated();

        $board = $action->execute($validated);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board created successfully!');
    }
    // ----------------------------------------------------------

    /**
     * Show the form for editing the specified board.
     *
     * @param  Board  $board
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
     * @param  BoardUpdateRequest  $request
     * @param  Board  $board
     * @param  UpdateBoardAction  $action
     *
     * @phpstan-param array<string, mixed> $validated
     *
     * @return RedirectResponse
     *
     * @phpstan-return \Illuminate\Http\RedirectResponse
     */
    public function update(BoardUpdateRequest $request, Board $board, UpdateBoardAction $action): RedirectResponse
    {
        $validated = $request->validated();

        $action->execute($board, $validated);

        return redirect()->route('dashboard.boards.show', $board)
            ->with('success', 'Board updated successfully!');
    }
    // ----------------------------------------------------------

    /**
     * Remove the specified board.
     *
     * @param  Board  $board
     * @param  DeleteBoardAction  $action
     * @return RedirectResponse
     *
     * @phpstan-return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Board $board, DeleteBoardAction $action): RedirectResponse
    {
        $action->execute($board);

        return redirect()->route('dashboard.index')
            ->with('success', 'Board deleted successfully');
    }
}

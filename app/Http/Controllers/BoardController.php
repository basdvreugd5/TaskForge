<?php

namespace App\Http\Controllers;

use App\Actions\Board\CreateBoardAction;
use App\Actions\Board\DeleteBoardAction;
use App\Actions\Board\UpdateBoardAction;
use App\Http\Requests\BoardStoreRequest;
use App\Http\Requests\BoardUpdateRequest;
use App\Models\Board;
use App\Traits\HandlesControllerExceptions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BoardController extends Controller
{
    use HandlesControllerExceptions;

    /**
     * Authorize resource actions for Board model.
     */
    public function __construct()
    {
        $this->authorizeResource(Board::class, 'board');
    }

    /**
     * Display the specified board along with its tasks.
     */
    public function show(Board $board): View
    {
        $board->loadActiveTasks();

        return view('dashboard.boards.show', compact('board'));
    }

    /**
     * Show the form for creating a new board.
     */
    public function create(): View
    {
        return view('dashboard.boards.create', [
            'board' => new Board(),
        ]);
    }

    /**
     * Store a newly created board.
     */
    public function store(BoardStoreRequest $request, CreateBoardAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn() => $action->handle($request->validated()),
            'Failed to create the board.',
            'Board creation failed.',
            route: 'dashboard.boards.show',
            successMessage: 'Board created successfully!',
        );
    }

    /**
     * Show the form for editing the specified board.
     */
    public function edit(Board $board): View
    {
        return view('dashboard.boards.edit', compact('board'));
    }

    /**
     * Update the specified board.
     */
    public function update(BoardUpdateRequest $request, Board $board, UpdateBoardAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn() => $action->handle($board, $request->validated()),
            errorMessage: 'Failed to update the board.',
            logMessage: 'Board update failed.',
            route: 'dashboard.boards.show',
            routeParams: [$board],
            successMessage: 'Board updated successfully!',
        );
    }

    /**
     * Remove the specified board.
     */
    public function destroy(Board $board, DeleteBoardAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn() => $action->handle($board),
            errorMessage: 'Failed to delete the board.',
            logMessage: 'Board deletion failed.',
            route: 'dashboard.index',
            successMessage: 'Board deleted successfully',
        );
    }
}

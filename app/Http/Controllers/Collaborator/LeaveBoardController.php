<?php

namespace App\Http\Controllers\Collaborator;

use App\Actions\Collaborator\LeaveBoardAction;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Traits\HandlesControllerExceptions;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LeaveBoardController extends Controller
{
    use HandlesControllerExceptions;

    public function __construct()
    {
        $this->middleware('can:leave,board');
    }

    /**
     * Allow the authenticated user to leave a shared board.
     */
    public function __invoke(Board $board, LeaveBoardAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn() => $action->handle($board, Auth::user()),
            errorMessage: 'Failed to leave the board.',
            logMessage: 'LeaveBoardController failed',
            context: [
                'board_id' => $board->id,
                'user_id' => Auth::id(),
            ],
            successMessage: "You have successfully left the board: {$board->name}",
        );
    }
}

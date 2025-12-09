<?php

namespace App\Http\Controllers\Collaborator;

use App\Actions\Collaborator\RemoveCollaboratorAction;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\User;
use App\Traits\HandlesControllerExceptions;
use Illuminate\Http\RedirectResponse;

class RemoveCollaboratorController extends Controller
{
    use HandlesControllerExceptions;

    public function __construct()
    {
        $this->middleware('can:removeCollaborator,board');
    }

    /**
     * Remove a collaborator from the given board.
     */
    public function __invoke(Board $board, User $collaborator, RemoveCollaboratorAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn() => $action->handle($board, $collaborator),
            errorMessage: 'Failed to remove collaborator.',
            logMessage: 'RemoveCollaboratorController failed',
            context: [
                'board_id' => $board->id,
                'collaborator_id' => $collaborator->id,
            ],
            successMessage: "{$collaborator->name} has been removed from the board.",
        );
    }
}

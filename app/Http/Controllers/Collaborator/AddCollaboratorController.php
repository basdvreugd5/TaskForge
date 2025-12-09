<?php

namespace App\Http\Controllers\Collaborator;

use App\Actions\Collaborator\AddCollaboratorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollaboratorStoreRequest;
use App\Models\Board;
use App\Models\User;
use App\Traits\HandlesControllerExceptions;
use Illuminate\Http\RedirectResponse;

class AddCollaboratorController extends Controller
{
    use HandlesControllerExceptions;

    public function __construct()
    {
        $this->middleware('can:addCollaborator,board');
    }

    /**
     * Add a collaborator to the specified board.
     */
    public function __invoke(CollaboratorStoreRequest $request, Board $board, AddCollaboratorAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn() => $action->handle(
                $board,
                User::where('email', $request->email)->firstOrFail(),
                $request->role,
            ),
            errorMessage: 'Failed to add collaborator.',
            logMessage: 'AddCollaboratorController failed',
            context: [
                'board_id' => $board->id,
                'email' => $request->email,
                'role' => $request->role,
            ],
            successMessage: "{$request->email} added as {$request->role}.",
        );
    }
}

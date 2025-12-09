<?php

namespace App\Http\Controllers\Collaborator;

use App\Actions\Collaborator\RemoveCollaboratorAction;
use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class RemoveCollaboratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:removeCollaborator,board');
    }

    /**
     * Remove a collaborator from the given board.
     */
    public function __invoke(Board $board, User $collaborator, RemoveCollaboratorAction $action): RedirectResponse
    {
        try {
            $action->handle($board, $collaborator);

            return back()->with('success', "{$collaborator->name} has been removed from the board.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

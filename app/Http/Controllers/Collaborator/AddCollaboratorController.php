<?php

namespace App\Http\Controllers\Collaborator;

use App\Actions\Collaborator\AddCollaboratorAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CollaboratorStoreRequest;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AddCollaboratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:addCollaborator,board');
    }

    /**
     * Add a collaborator to the specified board.
     *
     * @param  CollaboratorStoreRequest  $request
     * @param  Board  $board
     * @param  AddCollaboratorAction  $action
     * @return RedirectResponse
     */
    public function __invoke(CollaboratorStoreRequest $request, Board $board, AddCollaboratorAction $action): RedirectResponse
    {
        try {
            $collaborator = User::where('email', $request->email)->first();

            $action->execute($board, $collaborator, $request->role);

            return back()->with('success', "{$collaborator->name} added as {$request->role}.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

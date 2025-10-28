<?php

namespace App\Http\Controllers\Collaborator;

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(CollaboratorStoreRequest $request, Board $board): RedirectResponse
    {
        $collaborator = User::where('email', $request->email)->first();

        $board->collaborators()->syncWithoutDetaching([
            $collaborator->id => ['role' => $request->role],
        ]);

        return back()->with('success', "Collaborator {$collaborator->name} added/updated as {$request->role}.");
    }
}

<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Board;

class ManageCollaboratorsController extends Controller
{
    /**
     * Show the collaborator management view for the specified board.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Contracts\View\View
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Board $board)
    {
        $this->authorize('viewCollaborators', $board);

        return view('dashboard.boards.collaborators.manage', compact('board'));
    }
}

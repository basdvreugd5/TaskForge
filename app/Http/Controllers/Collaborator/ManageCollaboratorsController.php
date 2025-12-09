<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Board;

class ManageCollaboratorsController extends Controller
{
    /**
     * Show the collaborator management view for the specified board.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Board $board): \Illuminate\View\View
    {
        $this->authorize('viewCollaborators', $board);

        return view('dashboard.boards.collaborators.manage', compact('board'));
    }
}

<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Board;

class ManageCollaboratorsController extends Controller
{
    /**
     * Show the collaborator management view for the specified board.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function __invoke(Board $board)
    {
        $this->authorize('addCollaborator', $board);

        return view('dashboard.boards.collaborators.manage', compact('board'));
    }
}

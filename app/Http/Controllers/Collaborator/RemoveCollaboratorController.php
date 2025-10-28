<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class RemoveCollaboratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:removeCollaborator,board');
    }

    public function __invoke(Board $board, User $collaborator): RedirectResponse
    {
        if ($collaborator->id === $board->user_id) {
            return back()->with('error', 'The board owner cannot be removed.');
        }

        try {
            $deleted = $board->collaborators()->detach($collaborator->id);
        } catch (\Exception $e) {
            Log::error('Collaborator detach failed', [
                'board_id' => $board->id,
                'user_id' => $collaborator->id,
                'error' => $e->getMessage(),
            ]);
            $deleted = 0;
        }

        if ($deleted === 0) {
            return back()->with('error', 'Collaborator was not found on this board.');
        }

        return back()->with('success', "Collaborator {$collaborator->name} removed successfully.");
    }
}

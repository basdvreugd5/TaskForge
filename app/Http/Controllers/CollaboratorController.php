<?php

namespace App\Http\Controllers;

use App\Http\Requests\CollaboratorStoreRequest;
use App\Models\Board;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CollaboratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:addCollaborator,board')->only('store');
        $this->middleware('can:removeCollaborator,board')->only('destroy');
        $this->middleware('can:leave,board')->only('leaveBoard');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Store a newly added collaborator for the specified board.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CollaboratorStoreRequest $request, Board $board): RedirectResponse
    {
        $collaborator = User::where('email', $request->email)->first();

        $board->collaborators()->syncWithoutDetaching([
            $collaborator->id => ['role' => $request->role],
        ]);

        return back()->with('success', "Collaborator {$collaborator->name} added/updated as {$request->role}.");

    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Remove the specified collaborator from the board.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Board $board, User $collaborator): RedirectResponse
    {
        if ($collaborator->id === $board->user_id) {
            return back()->with('error', 'The board owner cannot be removed.');
        }

        $deletedCount = $this->detachCollaborator($board, $collaborator->id);

        if ($deletedCount === 0) {
            return back()->with('error', 'Collaborator was not found on this board.');
        }

        return back()->with('success', 'Collaborator removed successfully: '.$collaborator->name);
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Allows a collaborator to remove themselves (leave) from a board.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function leaveBoard(Board $board): RedirectResponse
    {
        $user = Auth::user();

        $deletedCount = $this->detachCollaborator($board, $user->id);

        if ($deletedCount === 0) {
            return back()->with('error', 'You were not found as a collaborator on this board.');
        }

        return redirect()->route('dashboard.index', ['type' => 'shared'])->with('success', 'You have successfully left the board: '.$board->name);
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Detach a collaborator and centralize error logging.
     */
    private function detachCollaborator(Board $board, int $userId): int
    {
        try {
            return $board->collaborators()->detach($userId);
        } catch (\Exception $e) {
            Log::error('Collaborator detach failed', [
                'board_id' => $board->id,
                'user_id' => $userId,
                'error' => $e->getMessage(),
            ]);

            return 0;
        }
    }
    // ------------------------------------------------------------------------------------------------------
}

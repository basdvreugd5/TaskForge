<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Added for better error handling
use Illuminate\Validation\Rule; // Added for more advanced validation options
use Illuminate\Support\Facades\DB; // Added for explicit pivot table check
use App\Http\Requests\CollaboratorStoreRequest;

class CollaboratorController extends Controller
{
    /**
     * Store a newly added collaborator for the specified board.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function store(CollaboratorStoreRequest $request, Board $board)
    {

        $collaborator = User::where('email', $request->email)->first();

        if ($collaborator->id === $board->user_id) {
            return back()->with('error', 'The board owner is automatically included and cannot be added manually.');
        }
           
        if ($board->collaborators()->where('user_id', $collaborator->id)->exists()) {
            return back()->with('error', 'This user is already a collaborator');
        }

        try {
            $board->collaborators()->attach($collaborator->id, ['role' => $request->role]);
            return back()->with('success', "Collaborator {$collaborator->name} added as {$request->role}.");
        } catch (\Exception $e) {
            Log::error('Collaborator attach failed', compact('board', 'collaborator', 'e'));
            return back()->with('error', 'Could not add collaborator. Please try again.');
        }
    }

    // ------------------------------------------------------------------------------------------------------

    /**
     * Remove the specified collaborator from the board.
     *
     * @param  \App\Models\Board  $board
     * @param  \App\Models\User  $collaborator (Using route model binding for the collaborator)
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board, User $collaborator)
    {
        $this->authorize('removeCollaborator', $board);

        if ($collaborator->id === $board->user_id) {
            return back()->with('error', 'The board owner cannot be removed.');
        }
        
        try {
            $deletedCount = $board->collaborators()->detach($collaborator->id);

            if ($deletedCount === 0) {
                 return back()->with('error', 'Collaborator was not found on this board.');
            }
            
            return back()->with('success', 'Collaborator removed successfully: ' . $collaborator->name);
            
        } catch (\Exception $e) {
             Log::error('Collaborator detach failed: ' . $e->getMessage(), ['board_id' => $board->id, 'collaborator_id' => $collaborator->id]);
             
             // Expose the error message in development/testing environments
             $errorMessage = app()->environment('local', 'testing') 
                ? 'Database error: ' . $e->getMessage() 
                : 'Could not remove collaborator. Please try again.';
            
            return back()->with('error', $errorMessage);
        }
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Allows a collaborator to remove themselves (leave) from a board.
     *
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function leaveBoard(Board $board)
    {

        $this->authorize('leave', $board);

        try {
            $user = Auth::user();

            $deletedCount = $board->collaborators()->detach($user->id);

            if ($deletedCount === 0) {
                 return back()->with('error', 'You were not found as a collaborator on this board.');
            }

            // Redirect back to the shared boards list after successfully leaving
            return redirect()->route('dashboard.shared')->with('success', 'You have successfully left the board: ' . $board->name);

        } catch (\Exception $e) {
             // Log the full error for server-side debugging
             Log::error('Collaborator self-detach failed: ' . $e->getMessage(), ['board_id' => $board->id, 'user_id' => Auth::id()]);

             // Expose the error message in development/testing environments
             $errorMessage = app()->environment('local', 'testing')
                ? 'Database error: ' . $e->getMessage()
                : 'Could not leave the board. Please try again.';

            return back()->with('error', $errorMessage);
        }
    }
}

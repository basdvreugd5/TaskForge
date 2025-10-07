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

class CollaboratorController extends Controller
{
    /**
     * Store a newly added collaborator for the specified board.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Board $board)
    {
        // 1. Authorization: Only the owner should add collaborators
        if (Auth::id() !== $board->user_id) {
            abort(403, 'You are not authorized to add collaborators to this board.');
        }

        // 2. Validation
        $request->validate([
            // 'exists' ensures the email belongs to a registered user
            'email' => ['required', 'email', 'exists:users,email'],
            // Validate role against only the allowed pivot roles (editor, viewer).
            'role' => ['required', Rule::in(['editor', 'viewer'])], 
        ]);
        
        // 3. Find the user to add
        $collaborator = User::where('email', $request->email)->first();

        // 4. Critical Redundancy Checks
        
        // Check A: Prevent adding the board's designated owner (defined by board->user_id)
        if ($collaborator->id === $board->user_id) {
            return back()->with('error', 'The board owner is automatically included and cannot be added manually.');
        }

        // Check B: Prevent adding a user who is ALREADY ATTACHED. 
        $isAlreadyAttached = DB::table('board_user')
            ->where('board_id', $board->id)
            ->where('user_id', $collaborator->id)
            ->exists();
            
        if ($isAlreadyAttached) {
            return back()->with('error', 'This user is already a collaborator on this board.');
        }
        
        // 5. Attach the collaborator to the board
        try {
            // FIX: Removed 'joined_at' because your database table 'board_user' does not have this column.
            $board->collaborators()->attach($collaborator->id, [
                'role' => $request->role, 
            ]);
            
            return back()->with('success', 'Collaborator added successfully: ' . $collaborator->name . ' as ' . ucfirst($request->role) . '.');

        } catch (\Exception $e) {
            // Log the full error for server-side debugging
            Log::error('Collaborator attach failed: ' . $e->getMessage(), ['board_id' => $board->id, 'collaborator_email' => $request->email]);
            
            // Expose the error message in development/testing environments to aid debugging
            $errorMessage = app()->environment('local', 'testing') 
                ? 'Database error: ' . $e->getMessage() 
                : 'Could not add collaborator due to a database error. Please check server logs.';
            
            return back()->with('error', $errorMessage);
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
        // 1. Authorization: Ensure the current user can remove collaborators
        if (Auth::id() !== $board->user_id) {
            abort(403, 'You are not authorized to remove collaborators from this board.');
        }

        // 2. Prevent removing the owner (the board creator)
        if ($collaborator->id === $board->user_id) {
            return back()->with('error', 'The board owner cannot be removed.');
        }
        
        // 3. Detach the collaborator
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
        $userId = Auth::id();

        // 1. Prevent owner from using 'leave' action (owner must delete the board)
        if ($userId === $board->user_id) {
            return back()->with('error', 'As the owner, you must delete the board if you no longer want it.');
        }

        // 2. Detach the current user from the board's collaborators
        try {
            $deletedCount = $board->collaborators()->detach($userId);

            if ($deletedCount === 0) {
                 return back()->with('error', 'You were not found as a collaborator on this board.');
            }

            // Redirect back to the shared boards list after successfully leaving
            return redirect()->route('dashboard.shared')->with('success', 'You have successfully left the board: ' . $board->name);

        } catch (\Exception $e) {
             // Log the full error for server-side debugging
             Log::error('Collaborator self-detach failed: ' . $e->getMessage(), ['board_id' => $board->id, 'user_id' => $userId]);

             // Expose the error message in development/testing environments
             $errorMessage = app()->environment('local', 'testing')
                ? 'Database error: ' . $e->getMessage()
                : 'Could not leave the board. Please try again.';

            return back()->with('error', $errorMessage);
        }
    }
}

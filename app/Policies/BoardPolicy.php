<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Traits\HasBoardRole;

class BoardPolicy
{
    use hasBoardRole;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Board $board): Response
    {
        
        return $this->hasAcces($user, $board) !== null
            ? Response::allow()
            : Response::deny('You do not have access to this board.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Board $board): Response
    {
        $role = $this->getRole($user, $board);

        return in_array($role, ['owner', 'editor']) 
            ? Response::allow()
            : Response::deny('You do not have permission to edit this board.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Board $board): Response
    {
        $role = $this->getRole($user, $board);

        return $this->getRole($user, $board) === 'owner' 
            ? Response::allow()
            : Response::deny('You do not have permission to delete this board');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }

    public function addCollaborator(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }

    public function removeCollaborator(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }

    public function leave(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) !== 'owner';
    }
}

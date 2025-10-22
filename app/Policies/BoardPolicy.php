<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use App\Traits\HasBoardRole;
use Illuminate\Auth\Access\Response;

class BoardPolicy
{
    use hasBoardRole;

    /**
     * Determine whether the user can view any models.
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function view(User $user, Board $board): Response
    {

        return $this->hasAccess($user, $board)
            ? Response::allow()
            : Response::deny('You do not have access to this board.');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the user can create models.
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function update(User $user, Board $board): Response
    {
        $role = $this->getRole($user, $board);

        return in_array($role, ['owner', 'editor'])
            ? Response::allow()
            : Response::deny('You do not have permission to edit this board.');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response
     */
    public function delete(User $user, Board $board): Response
    {
        $role = $this->getRole($user, $board);

        return $this->getRole($user, $board) === 'owner'
            ? Response::allow()
            : Response::deny('You do not have permission to delete this board');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the user can restore the model.
     *
     * @return bool
     */
    public function restore(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return bool
     */
    public function forceDelete(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Summary of addCollaborator
     *
     * @return bool
     */
    public function addCollaborator(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Summary of removeCollaborator
     *
     * @return bool
     */
    public function removeCollaborator(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) === 'owner';
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Summary of leave
     *
     * @return bool
     */
    public function leave(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) !== 'owner';
    }
    // ------------------------------------------------------------------------------------------------------
}

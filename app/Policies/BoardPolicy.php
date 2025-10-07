<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BoardPolicy
{
    protected function getRole(User $user, Board $board): ?string
    {
        if ($user->id === $board->user_id) {
            return 'owner';
        }

        $collaborator = $board->collaborators()->where('user_id', $user->id)->first();

        return $collaborator ? $collaborator->pivot->role : null;
                            
    }
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
        $role = $this->getRole($user, $board);

        return $role !== null
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

        if (in_array($role, ['owner', 'editor'])) {
            return Response::allow();
        }
        return Response::deny('You do not have permission to edit this board.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Board $board): Response
    {
        $role = $this->getRole($user, $board);

        if ($role === 'owner') {
            return Response::allow();
        }
        return Response::deny('You do not have permission to delete this board');
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
}

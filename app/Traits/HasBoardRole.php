<?php

namespace App\Traits;

use App\Models\Board;
use App\Models\User;

trait HasBoardRole
{
    protected function getRole(User $user, Board $board): ?string
    {
        if ($user->id === $board->user_id) {
            return 'owner';
        }

        // Use find() - it's cleaner than firstWhere('id', ...)
        // This finds the user *within* the relationship
        $collaborator = $board->collaborators()->find($user->id);

        // Access the pivot data as you had it
        return $collaborator ? $collaborator->pivot->role : null;
    }

    protected function hasAccess(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) !== null;
    }
}

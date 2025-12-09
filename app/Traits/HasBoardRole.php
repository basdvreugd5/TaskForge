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

        $collaborator = $board->collaborators()->find($user->id);

        return $collaborator ? $collaborator->pivot->role : null;
    }

    protected function hasAccess(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) !== null;
    }
}

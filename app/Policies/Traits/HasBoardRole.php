<?php

namespace App\Policies\Traits;

use App\Models\User;
use App\Models\Board;

trait HasBoardRole
{
    protected function getRole(User $user, Board $board): ?string
    {
        if ($user->id === $board->user_id) {
            return 'owner';
        }

        $collaborator = $board->collaborators()->where('user_id', $user->id)->first();

        return $collaborator ? $collaborator->pivot->role : null;
                            
    }

    protected function hasAcces(User $user, Board $board): bool
    {
        return $this->getRole($user, $board) !== null;
    }
}
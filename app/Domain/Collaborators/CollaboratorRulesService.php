<?php

namespace App\Domain\Collaborators;

use App\Models\Board;
use App\Models\User;
use RuntimeException;

class CollaboratorRulesService
{
    public function ensureUserCanBeAdded(Board $board, User $user): void
    {
        if ($user->id === $board->user_id) {
            throw new RuntimeException("Owner cannot be added as collaborator.");
        }
    }

    public function ensureUserCanBeRemoved(Board $board, User $user): void
    {
        if ($user->id === $board->user_id) {
            throw new RuntimeException("Owner cannot be removed from the board.");
        }
    }

    public function ensureUserCanLeave(Board $board, User $user): void
    {
        if ($user->id === $board->user_id) {
            throw new RuntimeException("Owner cannot leave their own board.");
        }
    }
}

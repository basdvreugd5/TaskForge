<?php

namespace App\Domain\Collaborators;

use App\Models\Board;
use App\Models\User;

class CollaboratorPersistenceService
{
    public function addCollaborator(Board $board, User $user, string $role): void
    {
        $board->collaborators()->syncWithoutDetaching([
            $user->id => ['role' => $role],
        ]);
    }

    public function removeCollaborator(Board $board, User $user): void
    {
        $board->collaborators()->detach($user->id);
    }
}

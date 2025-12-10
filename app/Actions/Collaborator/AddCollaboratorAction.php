<?php

namespace App\Actions\Collaborator;

use App\Models\Board;
use App\Models\User;

class AddCollaboratorAction
{
    public function __construct(
        protected \App\Domain\Collaborators\CollaboratorPersistenceService $persistence,
        protected \App\Domain\Collaborators\CollaboratorRulesService $rules,
    ) {}
    /**
     * Add a collaborator to a board.
     */
    public function handle(Board $board, User $collaborator, string $role): void
    {
        $this->rules->ensureUserCanBeAdded($board, $collaborator);
        $this->persistence->addCollaborator($board, $collaborator, $role);
    }

}

<?php

namespace App\Actions\Collaborator;

use App\Domain\Collaborators\CollaboratorPersistenceService;
use App\Domain\Collaborators\CollaboratorRulesService;
use App\Models\Board;
use App\Models\User;

class RemoveCollaboratorAction
{
    public function __construct(
        protected CollaboratorPersistenceService $persistence,
        protected CollaboratorRulesService $rules,
    ) {}
    public function handle(Board $board, User $collaborator): void
    {
        $this->rules->ensureUserCanBeRemoved($board, $collaborator);
        $this->persistence->removeCollaborator($board, $collaborator);
    }
}

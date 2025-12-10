<?php

namespace App\Actions\Collaborator;

use App\Domain\Collaborators\CollaboratorPersistenceService;
use App\Domain\Collaborators\CollaboratorRulesService;
use App\Models\Board;
use App\Models\User;

class LeaveBoardAction
{
    public function __construct(
        protected CollaboratorPersistenceService $persistence,
        protected CollaboratorRulesService $rules,
    ) {}
    /**
     * Leave from a shared board.
     *
     * @throws \RuntimeException
     */
    public function handle(Board $board, User $user): void
    {
        $this->rules->ensureUserCanLeave($board, $user);
        $this->persistence->removeCollaborator($board, $user);
    }
}

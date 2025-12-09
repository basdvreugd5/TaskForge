<?php

namespace App\Actions\Collaborator;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AddCollaboratorAction
{
    /**
     * Add a collaborator to a board.
     */
    public function handle(Board $board, User $collaborator, string $role): void
    {
        if ($collaborator->id === $board->user_id) {
            throw new \Exception("Owner of the Board can't be added as collaborator");
        }

        try {
            $board->collaborators()->syncWithoutDetaching([
                $collaborator->id => ['role' => $role],
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to add collaborator', [
                'board_id' => $board->id,
                'collaborator_id' => $collaborator->id,
                'error' => $e->getMessage(),
            ]);

            throw new \Exception('Failed to add collaborator.');
        }
    }
}

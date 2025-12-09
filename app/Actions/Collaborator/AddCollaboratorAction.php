<?php

namespace App\Actions\Collaborator;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class AddCollaboratorAction
{
    /**
     * Add a collaborator to a board.
     */
    public function handle(Board $board, User $collaborator, string $role): void
    {
        if ($collaborator->id === $board->user_id) {
            throw new RuntimeException("Owner of the Board can't be added as collaborator");
        }

        if ($board->collaborators()->where('user_id', $collaborator->id)->exists()) {
            throw new RuntimeException('That user is already a collaborator');
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

            throw new RuntimeException('Failed to add collaborator. Please try again.');
        }
    }
}

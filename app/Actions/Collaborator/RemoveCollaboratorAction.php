<?php

namespace App\Actions\Collaborator;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class RemoveCollaboratorAction
{
    public function execute(Board $board, User $collaborator): void
    {
        if ($collaborator->id === $board->user_id) {
            throw new \Exception('Board owner cannot be removed.');
        }

        try {
            $deleted = $board->collaborators()->detach($collaborator->id);
        } catch (\Throwable $e) {
            Log::error('Failed to detach collaborator', [
                'board_id' => $board->id,
                'collaborator_id' => $collaborator->id,
                'error' => $e->getMessage(),
            ]);
            throw new \Exception('Failed to remove collaborator.');
        }

        if ($deleted === 0) {
            throw new \Exception('Collaborator not found on this board.');
        }
    }
}

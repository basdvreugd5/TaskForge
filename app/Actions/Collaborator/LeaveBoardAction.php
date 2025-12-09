<?php

namespace App\Actions\Collaborator;

use App\Models\Board;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class LeaveBoardAction
{
    /**
     * Leave from a shared board.
     *
     * @throws \RuntimeException
     */
    public function handle(Board $board, User $user): void
    {
        $deleted = 0;

        try {
            $deleted = $board->collaborators()->detach($user->id);
        } catch (\Throwable $e) {
            Log::error('Collaborator leave failed', [
                'board_id' => $board->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            throw new RuntimeException('Failed to leave board. Please try again later.');
        }

        if ($deleted === 0) {
            throw new RuntimeException('You were not found as a collaborator on this board.');
        }
    }
}

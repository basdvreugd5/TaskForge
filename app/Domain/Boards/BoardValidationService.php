<?php

namespace App\Domain\Boards;

use App\Models\Board;
use RuntimeException;

class BoardValidationService
{
    public function ensureNameIsUnique(int $userId, string $name, ?int $excludeBoardId = null): void
    {
        $query = Board::where('user_id', $userId)
                      ->where('name', $name);
        if ($excludeBoardId) {
            $query->where('id', '!=', $excludeBoardId);
        }

        if ($query->exists()) {
            throw new RuntimeException('You already have a board with this name.');
        }
    }

    public function ensureBoardLimitNotExceeded(int $userId, int $limit = 10): void
    {
        if (Board::where('user_id', $userId)->count() >= $limit) {
            throw new RuntimeException('Board limit reached. Upgrade to create more.');
        }
    }
}

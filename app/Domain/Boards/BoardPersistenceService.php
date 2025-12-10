<?php

namespace App\Domain\Boards;

use App\Models\Board;
use Illuminate\Support\Facades\DB;

class BoardPersistenceService
{
    public function createBoard(int $userId, array $data): Board
    {
        return DB::transaction(function () use ($userId, $data) {
            $board = Board::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'user_id' => $userId,
            ]);

            $board->collaborators()->syncWithoutDetaching([
                $userId => ['role' => 'owner'],
            ]);

            return $board;
        });
    }

    public function updateBoard(Board $board, array $data): Board
    {
        $board->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return $board;
    }

    public function deleteBoard(Board $board): bool
    {
        return DB::transaction(function () use ($board) {
            return $board->delete();
        });
    }
}

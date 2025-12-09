<?php

namespace App\Actions\Board;

use App\Models\Board;

class UpdateBoardAction
{
    /**
     * Update an existing Board.
     */
    public function handle(Board $board, array $data): Board
    {
        $board->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return $board;
    }
}

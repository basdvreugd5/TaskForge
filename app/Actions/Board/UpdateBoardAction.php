<?php

namespace App\Actions\Board;

use App\Models\Board;

class UpdateBoardAction
{
    /**
     * Executes the board update logic.
     */
    public function execute(Board $board, array $data): Board
    {
        $board->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return $board;
    }
}

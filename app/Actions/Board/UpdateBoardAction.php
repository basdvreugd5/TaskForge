<?php

namespace App\Actions\Board;

use App\Models\Board;

class UpdateBoardAction
{
    /**
     * Update an existing Board.
     *
     * @param  \App\Models\Board  $board
     * @param  array<string, mixed>  $data
     * @return \App\Models\Board
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

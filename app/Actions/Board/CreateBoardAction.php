<?php

namespace App\Actions\Board;

use App\Models\Board;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateBoardAction
{
    /**
     * Create new Board.
     *
     * @param  array<string, mixed>  $data
     * @return \App\Models\Board
     */
    public function execute(array $data): Board
    {
        return DB::transaction(function () use ($data) {
            $board = Board::create([
                'name' => $data['name'],
                'description' => $data['description'],
                'user_id' => Auth::id(),
            ]);

            $board->collaborators()->syncWithoutDetaching([
                Auth::id() => ['role' => 'owner'],
            ]);

            return $board;
        });
    }
}

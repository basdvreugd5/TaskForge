<?php

namespace App\Actions\Board;

use App\Models\Board;
use Illuminate\Support\Facades\DB;

class DeleteBoardAction
{
    /**
     * Execute the board deletion logic.
     *
     * @return bool True if deleted successfully.
     */
    public function execute(Board $board): bool
    {
        return DB::transaction(function () use ($board) {

            return $board->delete();
        });
    }
}

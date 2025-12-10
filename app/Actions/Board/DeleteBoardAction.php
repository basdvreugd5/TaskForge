<?php

namespace App\Actions\Board;

use App\Domain\Boards\BoardPersistenceService;
use App\Models\Board;

class DeleteBoardAction
{
    public function __construct(
        protected BoardPersistenceService $persistence,
    ) {}
    /**
     * Board deletion logic.
     *
     * @return bool True if deleted successfully.
     */
    public function handle(Board $board): bool
    {
        return $this->persistence->deleteBoard($board);

    }
}

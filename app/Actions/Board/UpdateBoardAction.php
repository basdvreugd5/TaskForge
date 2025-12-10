<?php

namespace App\Actions\Board;

use App\Domain\Boards\BoardPersistenceService;
use App\Domain\Boards\BoardValidationService;
use App\Models\Board;

class UpdateBoardAction
{
    public function __construct(
        protected BoardValidationService $validator,
        protected BoardPersistenceService $persistence,
    ) {}
    /**
     * Update an existing Board.
     *
     * @throws \RuntimeException
     */
    public function handle(Board $board, array $data): Board
    {
        $this->validator->ensureNameIsUnique($board->user_id, $data['name'], $board->id);

        return $this->persistence->updateBoard($board, $data);
    }
}

<?php

namespace App\Actions\Board;

use App\Domain\Boards\BoardPersistenceService;
use App\Domain\Boards\BoardValidationService;
use App\Models\Board;
use Illuminate\Support\Facades\Auth;

class CreateBoardAction
{
    public function __construct(
        protected BoardValidationService $validator,
        protected BoardPersistenceService $persistence,
    ) {}
    /**
     * Create a new Board.
     */
    public function handle(array $data): Board
    {
        $user = Auth::user();

        $this->validator->ensureNameIsUnique($user->id, $data['name']);
        $this->validator->ensureBoardLimitNotExceeded($user->id);

        return $this->persistence->createBoard($user->id, $data);
    }
}

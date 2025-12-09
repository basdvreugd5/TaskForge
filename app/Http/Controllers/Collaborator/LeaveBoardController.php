<?php

namespace App\Http\Controllers\Collaborator;

use App\Actions\Collaborator\LeaveBoardAction;
use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LeaveBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:leave,board');
    }

    /**
     * Allow the authenticated user to leave a shared board.
     */
    public function __invoke(Board $board, LeaveBoardAction $action): RedirectResponse
    {
        try {
            $user = Auth::user();
            $action->handle($board, $user);

            return back()->with('success', "You have successfully left the board: {$board->name}");
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

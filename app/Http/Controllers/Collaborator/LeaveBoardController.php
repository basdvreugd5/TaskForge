<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use App\Models\Board;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LeaveBoardController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:leave,board');
    }

    public function __invoke(Board $board): RedirectResponse
    {
        $user = Auth::user();

        try {
            $deleted = $board->collaborators()->detach($user->id);
        } catch (\Exception $e) {
            Log::error('Collaborator leave failed', [
                'board_id' => $board->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            $deleted = 0;
        }

        if ($deleted === 0) {
            return back()->with('error', 'You were not found as a collaborator on this board.');
        }

        return redirect()->route('dashboard.index', ['type' => 'shared'])
            ->with('success', "You have successfully left the board: {$board->name}");
    }
}

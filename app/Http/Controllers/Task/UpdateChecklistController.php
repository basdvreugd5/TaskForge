<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class UpdateChecklistController extends Controller
{
    /**
     * Update the checklist.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'index' => 'required|integer',
            'is_completed' => 'required|boolean',
        ]);

        $checklist = $task->checklist ?? [];

        if (isset($checklist[$validated['index']])) {
            $checklist[$validated['index']]['is_completed'] = (bool) $validated['is_completed'];
        }

        $task->update(['checklist' => $checklist]);

        return response()->json([
            'success' => true,
            'checklist' => $checklist,
        ]);
    }
}

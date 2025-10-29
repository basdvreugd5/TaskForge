<?php

namespace App\Http\Controllers;

use App\Actions\Tag\AttachTagToTaskAction;
use App\Actions\Tag\DetachTagFromTaskAction;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskTagController extends Controller
{
    /**
     * Attach tag to task
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @param  \App\Actions\Tag\AttachTagToTaskAction  $attachTagToTaskAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Task $task, AttachTagToTaskAction $attachTagToTaskAction): RedirectResponse
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'name' => 'required|string:max:64',
        ]);

        $attachTagToTaskAction->execute($task, $validated['name']);

        return redirect()->route('dashboard.tasks.show', $task)->with('success', 'Tag attached to task successfully.');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Detach a tag from a task.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Models\Tag  $tag
     * @param  \App\Actions\Tag\DetachTagFromTaskAction  $detachTagFromTaskAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task, Tag $tag, DetachTagFromTaskAction $detachTagFromTaskAction): RedirectResponse
    {
        $this->authorize('update', $task);

        $detachTagFromTaskAction->execute($task, $tag);

        return redirect()->route('dashboard.tasks.show', $task)->with('success', 'Tag detached from task successfully.');
    }
    // ------------------------------------------------------------------------------------------------------
}

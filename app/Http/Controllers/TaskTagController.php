<?php

namespace App\Http\Controllers;

use App\Actions\Tag\AttachTagToTaskAction;
use App\Actions\Tag\DetachTagFromTaskAction;
use App\Http\Requests\TagAttachRequest;
use App\Http\Requests\TagDetachRequest;
use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;

class TaskTagController extends Controller
{
    /**
     * Attach tag to task
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @param  \App\Actions\Tag\AttachTagToTaskAction  $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagAttachRequest $request, Task $task, AttachTagToTaskAction $action): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $action->execute($task, $validated['name']);

            return redirect()
                ->route('dashboard.tasks.show', $task)
                ->with('success', 'Tag added successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    // ----------------------------------------------------------

    /**
     * Detach a tag from a task.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Models\Tag  $tag
     * @param  \App\Actions\Tag\DetachTagFromTaskAction  $action
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TagDetachRequest $request, Task $task, Tag $tag, DetachTagFromTaskAction $action): RedirectResponse
    {
        try {
            $action->execute($task, $tag);

            return redirect()
                ->route('dashboard.tasks.show', $task)
                ->with('success', "{$tag->name} removed successfully.");
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

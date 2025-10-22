<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Attach tag to task
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attach(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'name' => 'required|string:max:64',
        ]);

        $tag = Tag::firstOrCreate(['name' => $validated['name']]);

        $task->tags()->syncWithoutDetaching([$tag->id]);

        return redirect()->route('dashboard.tasks.show', $task)->with('success', 'Tag attached to task successfully.');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Detach a tag from a task.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function detach(Task $task, Tag $tag)
    {
        $this->authorize('update', $task);

        $task->tags()->detach($tag->id);

        return redirect()->route('dashboard.tasks.show', $task)->with('success', 'Tag detached from task successfully.');
    }
    // ------------------------------------------------------------------------------------------------------
}

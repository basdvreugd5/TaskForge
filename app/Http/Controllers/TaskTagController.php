<?php

namespace App\Http\Controllers;

use App\Actions\Tag\AttachTagToTaskAction;
use App\Actions\Tag\DetachTagFromTaskAction;
use App\Http\Requests\TagAttachRequest;
use App\Http\Requests\TagDetachRequest;
use App\Models\Tag;
use App\Models\Task;
use App\Traits\HandlesControllerExceptions;
use Illuminate\Http\RedirectResponse;

class TaskTagController extends Controller
{
    use HandlesControllerExceptions;

    /**
     * Attach tag to task
     */
    public function store(TagAttachRequest $request, Task $task, AttachTagToTaskAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn () => $action->handle($task, $request->validated()['name']),
            errorMessage: 'Failed to add the tag.',
            logMessage: 'Tag attach failed.',
            route: 'dashboard.tasks.show',
            routeParams: [$task],
            successMessage: 'Tag added successfully.'
        );
    }

    /**
     * Detach a tag from a task.
     */
    public function destroy(TagDetachRequest $request, Task $task, Tag $tag, DetachTagFromTaskAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn () => $action->handle($task, $tag),
            errorMessage: "Failed to remove {$tag->name}.",
            logMessage: 'Tag detach failed.',
            route: 'dashboard.tasks.show',
            routeParams: [$task],
            successMessage: "{$tag->name} removed successfully."
        );
    }
}

<?php

namespace App\Http\Controllers\Task;

use App\Actions\Task\UpdateChecklistItemAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateChecklistItemRequest;
use App\Models\Task;
use App\Traits\HandlesControllerExceptions;

class UpdateChecklistItemController extends Controller
{
    use HandlesControllerExceptions;
    public function __construct(
        protected UpdateChecklistItemAction $action,
    ) {}
    /**
     * Update a single checklist item.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(UpdateChecklistItemRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        return $this->handleActionException(
            fn() => $this->action->handle($task, $request->validated()),
            successResponse: fn() => response()->json([
                'success' => true,
                'checklist' => $task->fresh()->checklist,
            ]),
        );
    }
}

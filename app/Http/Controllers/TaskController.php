<?php

namespace App\Http\Controllers;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\DeleteTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Board;
use App\Models\Task;
use App\Traits\HandlesControllerExceptions;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TaskController extends Controller
{
    use HandlesControllerExceptions;

    /**
     * Display the specified task.
     */
    public function show(Task $task): View
    {

        $task->load(['board.tasks', 'tags']);

        return view('dashboard.tasks.show', compact('task'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create(Board $board): View
    {
        $this->authorize('create', [Task::class, $board]);

        return view('dashboard.tasks.create', [
            'task' => new Task,
            'board' => $board,
        ]);
    }

    /**
     * Store the task on the board.
     */
    public function store(TaskStoreRequest $request, Board $board, CreateTaskAction $action): RedirectResponse
    {
        return $this->handleActionException(
            fn () => $action->handle($board, $request->validated()),
            'Failed to create the task.',
            'Task creation failed.',
            ['board_id' => $board->id],
            route: 'dashboard.tasks.show',
            routeParams: [$board->tasks()->latest()->first()],
            successMessage: 'Task created successfully.'
        );
    }

    /**
     * Show the Form to edit the task details.
     */
    public function edit(Task $task): View
    {
        $this->authorize('view', $task);

        $task->load('board');
        $task->checklist = $task->formatted_checklist;

        return view('dashboard.tasks.edit', [
            'task' => $task,
            'board' => $task->board,
        ]);
    }

    /**
     * Update the task details.
     */
    public function update(TaskUpdateRequest $request, Task $task, UpdateTaskAction $action): RedirectResponse
    {
        $this->authorize('update', $task);

        return $this->handleActionException(
            fn () => $action->handle($task, $request->validated()),
            'Failed to update the task.',
            'Task update failed.',
            ['task_id' => $task->id],
            route: 'dashboard.boards.show',
            routeParams: [$task->board],
            successMessage: 'Task updated successfully.'
        );
    }

    /**
     * Delete the task.
     */
    public function destroy(Task $task, DeleteTaskAction $action): RedirectResponse
    {
        $this->authorize('delete', $task);

        return $this->handleActionException(
            fn () => $action->handle($task),
            'Failed to delete the task.',
            'Task deletion failed.',
            ['task_id' => $task->id],
            route: 'dashboard.boards.show',
            routeParams: [$task->board],
            successMessage: 'Task deleted successfully.'
        );
    }
}

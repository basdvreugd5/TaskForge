<?php

namespace App\Http\Controllers;

use App\Actions\Task\CreateTaskAction;
use App\Actions\Task\DeleteTaskAction;
use App\Actions\Task\UpdateTaskAction;
use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Board;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display the selected task.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['board.tasks', 'tags']);

        return view('dashboard.tasks.show', compact('task'));
    }
    // ----------------------------------------------------------

    /**
     * Create a new task.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Board $board)
    {
        $this->authorize('create', [Task::class, $board]);

        return view('dashboard.tasks.create', [
            'task' => new Task,
            'board' => $board,
        ]);
    }
    // ----------------------------------------------------------

    /**
     * Store the task on the board.
     *
     * @param  \App\Http\Requests\TaskStoreRequest  $request
     * @param  \App\Models\Board  $board
     * @param  \App\Actions\Task\CreateTaskAction  $createTaskAction
     *
     * @phpstan-param array<string, mixed> $validated
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @phpstan-return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskStoreRequest $request, Board $board, CreateTaskAction $createTaskAction)
    {
        $validated = $request->validated();

        $task = $createTaskAction->execute($board, $validated);

        return redirect()->route('dashboard.tasks.show', $task);
    }
    // ----------------------------------------------------------

    /**
     * Edit the task details.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $task->checklist = collect($task->checklist ?? [])->map(function ($item) {
            return [
                'title' => $item['title'] ?? '',
                'is_completed' => (bool) ($item['is_completed'] ?? false),
            ];
        })->toArray();

        $board = $task->board;

        return view('dashboard.tasks.edit', compact('task', 'board'));
    }
    // ----------------------------------------------------------

    /**
     * Update the task details.
     *
     * @param  \App\Http\Requests\TaskUpdateRequest  $request
     * @param  \App\Models\Task  $task
     * @param  \App\Actions\Task\UpdateTaskAction  $updateTaskAction
     *
     * @phpstan-param array<string, mixed> $validated
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskUpdateRequest $request, Task $task, UpdateTaskAction $updateTaskAction)
    {
        $validated = $request->validated();

        $updateTaskAction->execute($task, $validated);

        return redirect()->route('dashboard.tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }
    // ----------------------------------------------------------

    /**
     * Delete the task.
     *
     * @param  \App\Models\Task  $task
     * @param  \App\Actions\Task\DeleteTaskAction  $deleteTaskAction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task, DeleteTaskAction $deleteTaskAction)
    {
        $this->authorize('delete', $task);
        $board = $deleteTaskAction->execute($task);

        return redirect()
            ->route('dashboard.boards.show', $board)
            ->with('succes', 'Task deleted succesfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Board;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display the selected task.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['board.tasks', 'tags']);

        return view('dashboard.tasks.show', compact('task'));
    }
    // ------------------------------------------------------------------------------------------------------

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
    // ------------------------------------------------------------------------------------------------------

    /**
     * Store the task on the board.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskStoreRequest $request, Board $board)
    {
        $validated = $request->validated();

        $task = Task::create([
            'title' => $validated['title'],
            'board_id' => $board->id,
            'description' => $validated['description'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'hard_deadline' => $validated['hard_deadline'],
            'soft_due_date' => $validated['soft_due_date'],
            'checklist' => collect($validated['checklist'] ?? [])->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'is_completed' => $item['is_completed'] ?? false,
                ];
            })->toArray(),
        ]);

        return redirect()->route('dashboard.tasks.show', $task);
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Edit the task details.
     *
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
    // ------------------------------------------------------------------------------------------------------

    /**
     * Update the task details.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskUpdateRequest $request, Task $task)
    {
        $validated = $request->validated();

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'priority' => $validated['priority'],
            'hard_deadline' => $validated['hard_deadline'],
            'soft_due_date' => $validated['soft_due_date'],
            'checklist' => collect($validated['checklist'] ?? [])->map(function ($item) {
                return [
                    'title' => $item['title'],
                    'is_completed' => $item['is_completed'] ?? false,
                ];
            })->toArray(),
        ]);

        return redirect()->route('dashboard.tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }
    // ------------------------------------------------------------------------------------------------------

    /**
     * Delete the task.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $board = $task->board;
        $task->delete();

        return redirect()
            ->route('dashboard.boards.show', $board)
            ->with('succes', 'Task deleted succesfully');
    }
    // ------------------------------------------------------------------------------------------------------
}

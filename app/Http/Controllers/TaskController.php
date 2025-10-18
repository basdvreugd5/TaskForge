<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display the selected task.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        $task->load(['board.tasks', 'tags']);

        return view('dashboard.tasks.show', compact('task'));
    }

    /**
     * Create a new task.
     */
    public function create(Board $board)
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
    public function store(Request $request, Board $board)
    {
        $this->authorize('create', [Task::class, $board]);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1220',
            'status' => 'required|string|in:open,in_progress,review,done',
            'priority' => 'required|string|in:low,medium,high',
            'hard_deadline' => 'required|date',
            'soft_due_date' => 'nullable|date',
            'checklist' => 'nullable|array',
            'checklist.*.title' => 'required_with:checklist|string|max:255',
            'checklist.*.is_completed' => 'boolean',
        ]);

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

    /**
     * Edit the task details.
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

    /**
     * Update the task details.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1220',
            'status' => 'required|string|in:open,in_progress,review,done',
            'priority' => 'required|string|in:low,medium,high',
            'hard_deadline' => 'required|date',
            'soft_due_date' => 'nullable|date',
            'checklist' => 'nullable|array',
            'checklist.*.title' => 'required_with:checklist|string|max:255',
            'checklist.*.is_completed' => 'boolean',
        ]);

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

    /**
     * Update the checklist.
     */
    public function updateChecklist(Request $request, Task $task)
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

    /**
     * Delete the task.
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
}

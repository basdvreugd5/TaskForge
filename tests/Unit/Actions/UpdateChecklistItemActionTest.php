<?php

use App\Actions\Task\UpdateChecklistItemAction;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates the is_completed state of a checklist item', function () {
    $task = Task::factory()->create([
        'checklist' => [
            ['title' => 'First item', 'is_completed' => false],
            ['title' => 'Second item', 'is_completed' => false],
        ],
    ]);

    $action = new UpdateChecklistItemAction(new \App\Domain\Tasks\ChecklistService());

    $action->handle($task, [
        'index' => 1,
        'is_completed' => true,
    ]);

    $task->refresh();

    expect($task->checklist)->toBe([
        ['title' => 'First item', 'is_completed' => false],
        ['title' => 'Second item', 'is_completed' => true],
    ]);
});

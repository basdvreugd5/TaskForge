<?php

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('updates a checklist item and returns JSON', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'checklist' => [
            ['title' => 'Item 1', 'is_completed' => false],
            ['title' => 'Item 2', 'is_completed' => false],
        ],
    ]);

    $task->board->collaborators()->attach($user->id, ['role' => 'owner']);

    $this->actingAs($user)
        ->putJson(route('dashboard.tasks.checklist.update', $task), [
            'index' => 1,
            'is_completed' => true,
        ])
        ->assertOk()
        ->assertJson([
            'success' => true,
        ])
        ->assertJsonPath('checklist.1.is_completed', true);
});

it('forbids updating checklist for unauthorized user', function () {
    $task = Task::factory()->create();

    $this->actingAs(User::factory()->create())
        ->putJson(route('dashboard.tasks.checklist.update', $task), [
            'index' => 0,
            'is_completed' => true,
        ])
        ->assertForbidden();
});

it('fails validation when index is missing', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create();

    $task->board->collaborators()->attach($user->id, ['role' => 'owner']);

    $this->actingAs($user)
        ->putJson(route('dashboard.tasks.checklist.update', $task), [
            'is_completed' => true,
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['index']);
});

it('returns a JSON error when checklist index is invalid', function () {
    $user = User::factory()->create();
    $task = Task::factory()->create([
        'checklist' => [
            ['title' => 'Only item', 'is_completed' => false],
        ],
    ]);

    $task->board->collaborators()->attach($user->id, ['role' => 'owner']);

    $this->actingAs($user)
        ->putJson(route('dashboard.tasks.checklist.update', $task), [
            'index' => 5,
            'is_completed' => true,
        ])
        ->assertStatus(400)
        ->assertJson([
            'error' => 'Invalid checklist item index.',
        ]);
});

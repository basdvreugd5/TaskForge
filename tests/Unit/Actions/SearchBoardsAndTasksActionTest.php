<?php

use App\Actions\Search\SearchBoardsAndTasksAction;
use App\Filters\BoardFilter;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;

uses(RefreshDatabase::class);

it('returns boards and tasks when no search is provided', function () {
    $user = User::factory()->create();

    $boards = Board::factory()
        ->count(2)
        ->create(['user_id' => $user->id]);

    Task::factory()->count(3)->create([
        'board_id' => $boards->first()->id,
    ]);

    $filter = Mockery::mock(BoardFilter::class);
    $filter->shouldReceive('apply')
        ->once()
        ->andReturn(Board::whereIn('id', $boards->pluck('id')));

    $action = new SearchBoardsAndTasksAction($filter);

    $result = $action->handle([
        'user' => $user,
    ]);

    expect($result['boards'])->toHaveCount(2);
    expect($result['tasks']->count())->toBe(3);
});

// it filters boards by search term --- IGNORE ---
// it filters tasks by search term --- IGNORE ---
// it returns empty results when no boards match --- IGNORE ---

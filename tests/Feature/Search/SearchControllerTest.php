<?php

use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('redirects guests to login', function () {
    $this->get(route('dashboard.search.index'))
        ->assertRedirect('/login');
});

it('renders the dashboard search view', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard.search.index'))
        ->assertOk()
        ->assertViewIs('dashboard.index');
});

it('passes boards and tasks to the view', function () {
    $user = User::factory()->create();
    Board::factory()->count(2)->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->get(route('dashboard.search.index'))
        ->assertViewHasAll([
            'boards',
            'tasks',
            'filters',
        ]);
});

it('accepts a search query and returns the dashboard view', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('dashboard.search.index', [
            'search' => 'Match',
        ]))
        ->assertOk()
        ->assertViewIs('dashboard.index')
        ->assertViewHas('filters', function ($filters) {
            return $filters['search'] === 'Match';
        })
        ->assertViewHasAll([
            'boards',
            'tasks',
        ]);
});

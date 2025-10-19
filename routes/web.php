<?php

use App\Http\Controllers\BoardController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // Dashboard home
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::get('/shared', [BoardController::class, 'shared'])->name('shared');

        // Timeline Page -- WORK IN PROGRESS
        Route::get('/timeline', [App\Http\Controllers\TimelineController::class, 'index'])
            ->name('timeline');

        // Board routes
        Route::prefix('boards')->name('boards.')->group(function () {
            Route::get('create', [BoardController::class, 'create'])->name('create');
            Route::post('/', [BoardController::class, 'store'])->name('store');
            Route::get('{board}/edit', [BoardController::class, 'edit'])->name('edit');

            Route::get('{board}/manage-collaborators', [BoardController::class, 'manageCollaborators'])->name('manage.collaborators');

            Route::put('{board}', [BoardController::class, 'update'])->name('update');
            Route::delete('{board}', [BoardController::class, 'destroy'])->name('destroy');
            Route::get('{board}', [BoardController::class, 'show'])->name('show');

            // FIX: Route for a user to leave a board. This route name resolves to 'dashboard.boards.leave'.
            Route::delete('{board}/leave', [CollaboratorController::class, 'leaveBoard'])->name('leave');
        });

        // Collaborator-specific management routes (adding, updating, removing other users)
        // Note: The board ID is part of the group prefix.
        Route::prefix('boards/{board}')->name('collaborators.')->group(function () {
            Route::post('collaborators', [CollaboratorController::class, 'store'])->name('store');
            Route::put('collaborators/{collaborator}', [CollaboratorController::class, 'update'])->name('update');
            Route::delete('collaborators/{collaborator}', [CollaboratorController::class, 'destroy'])->name('destroy');
        });

        // Board → Task routes
        Route::prefix('boards/{board}')->name('boards.')->group(function () {
            Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
            Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
        });

        // Direct Task routes
        Route::prefix('tasks')->name('tasks.')->group(function () {
            Route::get('{task}/edit', [TaskController::class, 'edit'])->name('edit');
            Route::put('{task}', [TaskController::class, 'update'])->name('update');
            Route::put('{task}/checklist', [TaskController::class, 'updateChecklist'])->name('checklist.update');
            Route::delete('{task}', [TaskController::class, 'destroy'])->name('destroy');
            Route::get('{task}', [TaskController::class, 'show'])->name('show');
        });

        Route::post('/tasks/{task}/tags', [App\Http\Controllers\TagController::class, 'attach'])
            ->name('tasks.tags.attach');
        Route::delete('/tasks/{task}/tags/{tag}', [App\Http\Controllers\TagController::class, 'detach'])
            ->name('tasks.tags.detach');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

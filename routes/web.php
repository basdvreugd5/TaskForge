<?php

use App\Http\Controllers\Board\ManageCollaboratorsController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\Collaborator\AddCollaboratorController;
use App\Http\Controllers\Collaborator\LeaveBoardController;
use App\Http\Controllers\Collaborator\RemoveCollaboratorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Task\UpdateChecklistController;
use App\Http\Controllers\TaskController;
use App\Models\Board;
use App\Models\Task;
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

        // Search Page
        Route::get('/search', [SearchController::class, 'index'])->name('search.index');

        // Timeline Page -- WORK IN PROGRESS
        Route::get('/timeline', [App\Http\Controllers\TimelineController::class, 'index'])
            ->name('timeline');

        // Board routes
        Route::prefix('boards')->name('boards.')->group(function () {
            Route::get('create', [BoardController::class, 'create'])->name('create');
            Route::post('/', [BoardController::class, 'store'])->name('store');
            Route::get('{board}/edit', [BoardController::class, 'edit'])->name('edit');
            Route::put('{board}', [BoardController::class, 'update'])->name('update');
            Route::delete('{board}', [BoardController::class, 'destroy'])->name('destroy');
            Route::get('{board}', [BoardController::class, 'show'])->name('show');

            Route::get('{board}/manage-collaborators', ManageCollaboratorsController::class)->name('manage.collaborators');

            Route::delete('boards/{board}/leave', LeaveBoardController::class)
                ->name('boards.leave');

        });

        // Collaborator routes
        Route::prefix('boards/{board}/collaborators')->name('boards.collaborators.')->group(function () {
            Route::post('/', AddCollaboratorController::class)->name('store');
            Route::delete('{collaborator}', RemoveCollaboratorController::class)->name('destroy');
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
            Route::put('{task}/checklist', UpdateChecklistController::class)->name('checklist.update');
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

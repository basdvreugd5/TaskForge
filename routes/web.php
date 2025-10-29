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
use App\Http\Controllers\TaskTagController;
use App\Http\Controllers\TimelineController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {

        // ... Dashboard, Search, Timeline routes ...
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::get('/search', [SearchController::class, 'index'])->name('search.index');
        Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');

        // ----------------------------------------------------------------------
        // RESOURCE & CUSTOM ROUTES
        // ----------------------------------------------------------------------

        // Board Resource
        Route::resource('boards', BoardController::class)->only(['create', 'store', 'edit', 'update', 'destroy', 'show']);

        // Custom Board Routes
        Route::get('boards/{board}/manage-collaborators', ManageCollaboratorsController::class)->name('boards.manage.collaborators');
        Route::delete('boards/{board}/leave', LeaveBoardController::class)->name('boards.leave');

        // Task Creation
        Route::resource('boards.tasks', TaskController::class)->only(['create', 'store']);

        // Task Management
        Route::resource('tasks', TaskController::class)->except(['index', 'create', 'store']);

        // Custom Task Route
        Route::put('tasks/{task}/checklist', UpdateChecklistController::class)->name('tasks.checklist.update');

        // Collaborator routes
        Route::prefix('boards/{board}/collaborators')->name('boards.collaborators.')->group(function () {
            Route::post('/', AddCollaboratorController::class)->name('store');
            Route::delete('{collaborator}', RemoveCollaboratorController::class)->name('destroy');
        });

        // Task Tag routes
        Route::resource('tasks.tags', TaskTagController::class)->only(['store', 'destroy']);
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

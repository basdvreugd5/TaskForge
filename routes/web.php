<?php

use App\Models\Board;
use App\Models\User;
use App\Models\Task;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\BoardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function() {

    // Dashboard home
    Route::get('/', function () {
        $user = Auth::user();
        $boards = $user->boards()->withCount('tasks')->get();
        $tasks = Task::whereIn('board_id', $user->boards()->pluck('id'))
            ->with('board')
            ->orderBy('hard_deadline', 'asc')
            ->paginate(5);
            
        return view('dashboard.index', compact('user', 'boards', 'tasks'));
    })->name('index');

    //Timeline Page -- WORK IN PROGRESS
    Route::get('/timeline',function() {
        return view('dashboard.timeline');
    })->name('timeline');

    //Board routes
    Route::prefix('boards')->name('boards.')->group(function () {
        Route::get('create', [BoardController::class, 'create'])->name('create');
        Route::post('/', [BoardController::class, 'store'])->name('store');
        Route::get('{board}/edit', [BoardController::class, 'edit'])->name('edit');
        Route::put('{board}', [BoardController::class, 'update'])->name('update');
        Route::delete('{board}', [BoardController::class, 'destroy'])->name('destroy');
        Route::get('{board}', [BoardController::class, 'show'])->name('show');
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
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');    
});

require __DIR__.'/auth.php';

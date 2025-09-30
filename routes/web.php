<?php

use App\Models\Board;
use App\Models\User;
use App\Models\Task;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->group(function() {

    // Dashboard home
    Route::get('/', function () {
        $user = Auth::user();
        $boards = $user->boards()->withCount('tasks')->get();
        $tasks = Task::whereIn('board_id', $user->boards()->pluck('id'))
            ->with('board')
            ->orderBy('hard_deadline', 'asc')
            ->paginate(5);
            
        return view('dashboard', compact('user', 'boards', 'tasks'));
    })->name('dashboard');

    //Timeline Page
    Route::get('/timeline',function() {
        return view('timeline');
    })->name('timeline');

    //Individual Boards

    Route::get('boards/{board}', function(Board $board) {
        $board->load(['tasks' => function($query) {
            $query->whereIn('status', ['open', 'in_progress', 'review', 'done']);
        }]);
        return view('boards.show', compact('board'));
    })->name('boards.show');

    
    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('boards/{board}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('boards/{board}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';

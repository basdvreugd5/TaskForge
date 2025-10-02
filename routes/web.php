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



// Route::get('/boards/create', function () {
//     return view('boards.create', [
//         'board' => new Board(), // empty model
//     ]);
// })->name('boards.create');
//     //Individual Boards

//     Route::get('boards/{board}', function(Board $board) {
//         $board->load(['tasks' => function($query) {
//             $query->whereIn('status', ['open', 'in_progress', 'review', 'done']);
//         }]);
//         return view('boards.show', compact('board'));
//     })->name('boards.show');

    route::get('/boards{board}', [BoardController::class, 'show'])->name('boards.show');
    route::get('/boards/create', [BoardController::class, 'create'])->name('boards.create');
    Route::post('/boards', [BoardController::class, 'store'])->name('boards.store');
    Route::get('/boards/{board}/edit', [BoardController::class, 'edit'])->name('boards.edit');
    Route::put('boards/{board}', [BoardController::class, 'update'])->name('boards.update');
    Route::delete('/boards/{board}', [BoardController::class, 'destroy'])->name('boards.destroy');   


    Route::get('tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('boards/{board}/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('boards/{board}/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::put('/tasks/{task}/checklist', [TaskController::class, 'updateChecklist'])->name('tasks.checklist.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

    

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';

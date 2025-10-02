<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 

class BoardController extends Controller
{
    //Index

    //Show

    public function show(Board $board) 
    {
        $board->load(['tasks' => function($query) {
            $query->whereIn('status', ['open', 'in_progress', 'review', 'done']);
        }]);
        
        return view ('boards.show', compact('board'));
    }

    //Create
    public function create() 
    {
        return view('boards.create',[
            'board' => new Board(),
        ]);
    }

    //Store
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $board = Board::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('boards.show', $board)
        ->with('succes', 'Board created successfully!');
    }
    
    //Edit
    public function edit(Board $board)
    {
        return view('boards.edit', compact('board'));
    }

    //Update
    public function update(Request $request, Board $board)
    {
        // Validate incoming request
        $validated =$request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        //Update the board using mass assignment.
        $board->update([
            'name' => $validated['name'],
            'description' => $validated['description']
        ]);

        //Redirect back to the board page.
        return redirect()->route('boards.show', $board)->with('success', 'Board updated successfully!');
    }

    
    //Destroy
    public function destroy(Board $board) 
    {
        $board->delete();

        return redirect()
        ->route('dashboard')
        ->with('success', 'Board deleted succesfully');
    }
    

}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'desc')->get();
        return view('todo.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        Task::create([
            'title' => $request->title,
        ]);
        return redirect()->back();
    }

    public function toggle(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
}

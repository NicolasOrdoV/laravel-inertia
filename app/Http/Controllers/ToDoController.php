<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ToDoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', Auth::id())->orderBy('count')->get();
        return inertia('Todo/Index', compact('todos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        Todo::create([
            'name' => $data['name'],
            'count' => Todo::where('user_id', Auth::id())->count(),
            'user_id' => Auth::id(),
        ]);

        return back();
    }

    public function update(Todo $todo, Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:2|max:255',
        ]);

        Todo::where('id', $todo->id)->where('user_id', Auth::id())->update([
            'name' => $data['name'],
        ]);

        return back();
    }

    public function destroy(?Todo $todo = null)
    {
        if($todo == null) {
            Todo::where('user_id', Auth::id())->delete();
        } else {
            Todo::where('id', $todo->id)->where('user_id', Auth::id())->delete();
        }

        return back();
    }

    public function status(Todo $todo)
    {
        Todo::where('id', $todo->id)->where('user_id', Auth::id())->update([
            'status' => request('status') == '1',
        ]);
        return back();
    }

    function order()
    {
        foreach(request('ids') as $count => $id) {
            Todo::where('id', $id)->where('user_id', Auth::id())->update([
                'count' => $count,
            ]);
        }
    }
}

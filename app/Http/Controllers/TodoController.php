<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use App\Models\TodoItem;

class TodoController extends Controller
{
    public function index()
    {
        return inertia('Todos/Index', [
            'todos' => Todo::with(['author'])->latest()->get()
        ]);
    }

    public function store(TodoRequest $request)
    {
        $attr = $request->validated();

        $authenticated = auth()->user();

        $todo = $authenticated->todos()->create(collect($attr)->only('title')->toArray());

        $todo->items()->createMany($attr['items']);

        return response()->json(['success' => 'Success'], 200);
    }

    public function toggleStatus(TodoItem $todo)
    {
        $todo->update(['completed' => request('completed') ? now() : null]);

        return response(['success' => 'Status has been updated.'], 200);
    }
}

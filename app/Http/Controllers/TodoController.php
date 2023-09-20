<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoItemRequest;
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
        $validated = $request->validated();

        $authenticated = auth()->user();

        $todo = $authenticated->todos()->create(collect($validated)->only('title')->toArray());

        $todo->items()->createMany($validated['items']);

        return response()->json(['success' => 'Tasks Created'], 200);
    }

    public function storeItem(TodoItemRequest $request, Todo $todo)
    {
        $validated = $request->validated();

        $todo->items()->create($validated);

        return response()->json(['success' => 'Task Updated'], 200);
    }

    public function updateItem(TodoItemRequest $request, TodoItem $item)
    {
        $validated = $request->validated();

        $item->update($validated);

        return response()->json(['success' => 'Task Updated'], 200);
    }

    public function destroyItem(TodoItem $item)
    {
        $item->delete();

        return response()->json(['success' => 'Task Deleted!']);
    }

    public function toggleStatus(TodoItem $item)
    {
        $validated = request()->validate(['completed' => 'required']);

        $item->update(['completed' => $validated['completed'] ? now() : null]);

        return response(['success' => 'Task Status Updated!'], 200);
    }
}

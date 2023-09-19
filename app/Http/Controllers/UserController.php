<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function index()
    {
        return inertia('Users/Index', ['roles' => Role::get()]);
    }

    public function store(UserRequest $request)
    {
        User::create($request->validated());

        return response()->json(['success' => 'User Created!'], 200);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json(['success' => 'User Updated!'], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['success' => 'User Deleted!']);
    }

    public function list()
    {
        abort_unless(request()->wantsJson(), 404);

        $query = User::with(['role:id,name']);

        return JsonResource::collection($query->get());
    }
}

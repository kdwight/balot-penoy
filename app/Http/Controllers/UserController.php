<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function list()
    {
        abort_unless(request()->wantsJson(), 404);

        $query = User::with('role:name');

        return JsonResource::collection($query->get());
    }

    public function store()
    {
        User::create($this->validateUser());

        return response()->json(['success' => 'User Created!'], 200);
    }

    public function update(User $user)
    {
        $user->update($this->validateUser($user));

        return response()->json(['success', 'User Updated!'], 200);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User Deleted!');
    }

    protected function validateUser(?User $user = null): array
    {
        $user ??= new User();

        $rules = [
            'username' => ['required', 'string', 'min:5', 'max:20'],
            'email' => ['required', Rule::unique('users', 'email')->ignore($user)],
            'password' => ['required', 'string', 'min:8'],
        ];

        if (request()->has('role_id')) {
            $rules['role_id'] = ['required', Rule::exists('roles', 'id')];
        }

        return request()->validate($rules);
    }
}

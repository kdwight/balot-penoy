<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()?->role_id === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'username' => ['required', 'string', 'min:5', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->route()->user?->id)],
            'role_id' => ['nullable', Rule::exists('roles', 'id')]
        ];

        if (request()->isMethod('post')) {
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        return $rules;
    }
}

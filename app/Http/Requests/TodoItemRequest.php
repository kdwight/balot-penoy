<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (auth()->id() == $this->user()->id) || in_array('todos', array_column(auth()->user()->role->pages ?? [], 'name'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'target_date' => ['sometimes', 'required', 'date', 'after_or_equal:today']
        ];
    }
}

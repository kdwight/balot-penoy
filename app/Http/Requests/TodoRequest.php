<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // $this->user()->can('update', $todo)
        return (auth()->id() == $this->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:150'],
            'items.*.title' => ['required', 'string'],
            'items.*.target_date' => ['sometimes', 'required', 'date', 'after_or_equal:today']
        ];
    }

    public function messages()
    {
        return [
            'items.*' => 'Please select a designated role for the user.'
        ];
    }
}

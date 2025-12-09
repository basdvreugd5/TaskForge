<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagAttachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = $this->route('task'); // route model binding

        return $task && $this->user()?->can('update', $task);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:64', 'min:1'],
        ];
    }
}

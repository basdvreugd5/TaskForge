<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagDetachRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $task = $this->route('task'); // route model binding

        return $task && $this->user()?->can('update', $task);
    }
}

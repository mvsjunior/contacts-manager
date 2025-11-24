<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste depois se for usar auth
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:5'],
            'email' => [
                'required',
                'email',
                Rule::unique('people', 'email')->whereNull('deleted_at'),
            ],
            // 'avatar' => ['nullable', 'string'],
        ];
    }
}

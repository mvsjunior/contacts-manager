<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PersonUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('person');

        return [
            'name' => ['required', 'string', 'min:5'],
                'email' => [
                    'required',
                    'email',
                    'unique:people,email,' . $this->id
                ],
            // 'avatar' => ['nullable', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('contact');

        return [
            'person_id' => ['required', 'exists:people,id'],
            'country_code' => ['required', 'string'],
            'number' => ['required', 'digits:9'],

            Rule::unique('contacts')
                ->ignore($id)
                ->where('country_code', $this->country_code)
                ->where('number', $this->number)
                ->whereNull('deleted_at'),
        ];
    }
}

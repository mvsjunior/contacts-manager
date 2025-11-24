<?php

namespace App\Http\Requests\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'person_id' => ['required', 'exists:people,id'],
            'country_code' => ['required', 'string'],
            'number' => ['required', 'digits:9'],
            Rule::unique('contacts')
                ->where('country_code', $this->country_code)
                ->where('number', $this->number)
                ->whereNull('deleted_at'),
        ];
    }
}

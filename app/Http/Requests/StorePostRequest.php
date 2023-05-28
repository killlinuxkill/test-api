<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'translations' => 'nullable|array',
            'translations.*.title' => 'required|string|min:5|max:255',
            'translations.*.description' => 'required|string|min:10|max:500',
            'translations.*.content' => 'required|string',
            'translations.*.language' => 'required|string|min:1|max:2',
            'tags' => 'nullable|array',
            'tags.*.id' => 'numeric'
        ];
    }
}

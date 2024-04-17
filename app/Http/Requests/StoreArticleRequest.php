<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation()
    {
        $this->merge([
            "tags" => json_decode($this->tags, true),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'abstract' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:1000'],
            'tags' => ['required', 'array', 'max:10', 'unique_in_array'],
            'tags.*' => ['string', 'max:255'],
        ];
    }
}

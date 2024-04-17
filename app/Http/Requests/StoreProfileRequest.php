<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->user()->email !== $this->email) {
            return [
                'name' => ['required', 'string', 'max:255'],
                "bio" => ["string", "max:255", "nullable"],
                "avatar" => ["url", "max:255", "nullable"],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ];
        } else {
            return [
                'name' => ['required', 'string', 'max:255'],
                "bio" => ["string", "max:255", "nullable"],
                "avatar" => ["url", "max:255", "nullable"],
            ];
        }
    }
}

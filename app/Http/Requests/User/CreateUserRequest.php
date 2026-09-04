<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use App\Enums\Role;

class createUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255', 'min:3', 'string'],
            'lastname' => ['required', 'max:255', 'min:3', 'string'],
            'password' => ['required', Password::min(8)
                                        ->mixedCase()
                                        ->numbers()],
            'birth_date' => ['required', 'date'],
            'role' => ['required', Rule::enum(Role::class)],
            'ddd' => ['required', 'max:4', 'string'],
            'phone' => ['required', 'digits:9', Rule::unique('users', 'phone')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
        ];
    }
}

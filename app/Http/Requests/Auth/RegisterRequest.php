<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "RegisterRequest",
    required: ["name", "surname", "email", "phone", "password", "password_confirmation"],
    properties: [
        new OA\Property(property: "name", type: "string", example: "Иван", maxLength: 255, minLength: 2),
        new OA\Property(property: "surname", type: "string", example: "Иванов", maxLength: 255, minLength: 2),
        new OA\Property(property: "patronymic", type: "string", example: "Иванович", maxLength: 255, minLength: 2),
        new OA\Property(property: "email", type: "string", format: "email", example: "ivan@example.com", maxLength: 255),
        new OA\Property(property: "phone", type: "string", example: "+79991234567"),
        new OA\Property(property: "password", type: "string", format: "password", example: "Password123!", minLength: 8),
        new OA\Property(property: "password_confirmation", type: "string", format: "password", example: "Password123!"),
    ]
)]
class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'min:2', 'max:255'],
            'surname'    => ['required', 'string', 'min:2', 'max:255'],
            'patronymic' => ['nullable', 'string', 'min:2', 'max:255'],
            'email'      => ['required', 'email:rfc,dns', 'max:255', 'unique:users,email'],
            'phone'      => ['required', 'string', 'unique:users,phone'],
            'password'   => ['required', 'confirmed', Password::defaults()],
        ];
    }
}

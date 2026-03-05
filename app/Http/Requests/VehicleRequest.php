<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
            'license_plate' => ['required', 'string', 'regex:/^[A-Z0-9\s-]{5,12}$/i',
                Rule::when(
                    $this->input('is_foreign') === false,
                    [
                        'regex:/^[АВЕКМНОРСТУХ]\d{3}[АВЕКМНОРСТУХ]{2}\s?\d{3}$/iu', //
                        'min:9',
                        'max:12'
                    ],
                    [
                        'regex:/^[A-Z0-9\s\-]{5,12}$/i',
                    ]
                )
            ],
            'is_default' => ['required', 'boolean'],
            'is_foreign' => ['required', 'boolean'],
            'vehicle_category_id' => ['required', 'integer', 'exists:vehicle_categories,id'],
        ];
    }
}

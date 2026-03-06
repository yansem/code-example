<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "VehicleRequest",
    required: ["license_plate", "is_default", "is_foreign", "vehicle_category_id"],
    properties: [
        new OA\Property(
            property: "license_plate",
            description: "Номерной знак. Формат зависит от значения is_foreign",
            type: "string",
            pattern: "^[A-Z0-9\\s-]{5,12}$",
            example: "А123ЕВ456",
            maxLength: 12,
            minLength: 5,
        ),
        new OA\Property(
            property: "is_default",
            description: "Является ли это транспортное средство основным",
            type: "boolean",
            example: false
        ),
        new OA\Property(
            property: "is_foreign",
            description: "Иностранный номер (true) или российский (false)",
            type: "boolean",
            example: false
        ),
        new OA\Property(
            property: "vehicle_category_id",
            description: "ID категории ТС",
            type: "integer",
            example: 1
        ),
    ],
    type: "object"
)]
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
            'license_plate' => ['required', 'string', 'unique:App\Models\Vehicle,license_plate',
                Rule::when(
                    $this->input('is_foreign') === false,
                    [
                        'regex:/^[АВЕКМНОРСТУХ]\d{3}[АВЕКМНОРСТУХ]{2}\d{3}$/iu', //
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

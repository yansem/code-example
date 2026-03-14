<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "ParkingRequest",
    required: ["duration", "is_auto_renewal", "vehicle_id", "zone_id"],
    properties: [
        new OA\Property(
            property: "duration",
            description: "Длительность в минутах",
            type: "integer",
            example: "60"
        ),

        new OA\Property(
            property: "is_auto_renewal",
            description: "Продление существующей парковки",
            type: "boolean",
            example: false
        ),

        new OA\Property(
            property: "vehicle_id",
            description: "ID транспортного средства",
            type: "integer",
            example: 12
        ),

        new OA\Property(
            property: "zone_id",
            description: "ID парковочной зоны",
            type: "integer",
            example: 5
        ),
    ],
    type: "object"
)]
class ParkingRequest extends FormRequest
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
            'duration' => ['required', 'integer', 'min:60'],
            'is_auto_renewal' => ['required', 'boolean'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'zone_id' => ['required', 'integer', 'exists:zones,id'],
        ];
    }
}

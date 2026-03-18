<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParkingSessionRequest extends FormRequest
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

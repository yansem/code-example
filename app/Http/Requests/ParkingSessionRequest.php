<?php

namespace App\Http\Requests;

use App\DTO\Parking\ParkingSessionData;
use App\Services\ParkingService;
use App\Support\MoneyFormatter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'], //todo: принадлежность user?
            'zone_id' => ['required', 'integer', 'exists:zones,id'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                $amount = app(ParkingService::class)->calculateCost(
                    new ParkingSessionData(
                        zoneId: $this->zone_id,
                        vehicleId: $this->vehicle_id,
                        duration: $this->duration,
                    )
                );

                if (auth()->user()->balance->balance < $amount) {
                    $validator->errors()->add(
                        'amount',
                        __('На вашем балансе недостаточно средств. Необходимо: :amount ₽. Доступно: :balance ₽.', [
                            'amount' => MoneyFormatter::format($amount),
                            'balance' => MoneyFormatter::format(auth()->user()->balance->balance),
                        ])
                    );
                }
            },
        ];
    }
}

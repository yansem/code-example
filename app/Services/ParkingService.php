<?php

namespace App\Services;

use App\Domain\Parking\ParkingCostCalculator;
use App\Domain\Parking\ParkingRates;
use App\Domain\Parking\ParkingTimeCalculator;
use App\DTO\Parking\CreateParkingData;
use App\Models\Parking;
use App\Models\Rate;

readonly class ParkingService
{
    public function __construct(
        private ParkingTimeCalculator $timeCalculator,
        private ParkingCostCalculator $costCalculator
    ) {}
    public function store(CreateParkingData $data): void
    {
        $startAt = now();
        $endAt = $startAt->copy()->addMinutes($data->duration);

        $paidTime = $this->timeCalculator->calculate($startAt, $endAt);
        $rates = $this->getRates($data->zoneId, $data->vehicleId);

        $cost = $this->costCalculator->calculate($rates, $paidTime);

        Parking::query()->create([
            'start_at' => $startAt,
            'end_at' => $endAt,
            'is_auto_renewal' => $data->isAutoRenewal,
            'cost' => $cost,
            'vehicle_id' => $data->vehicleId,
            'zone_id' => $data->zoneId
        ]);
    }

    public function getRates(int $zoneId, int $vehicleId): ParkingRates
    {
        $rate = Rate::query()
            ->join('zones', 'zones.zone_category_id', '=', 'rates.zone_category_id')
            ->join('vehicles', 'vehicles.vehicle_category_id', '=', 'rates.vehicle_category_id')
            ->where('zones.id', $zoneId)
            ->where('vehicles.id', $vehicleId)
            ->firstOrFail(['rates.hourly_rate', 'rates.minutely_rate']);

        $hourlyRate = $rate->hourly_rate;
        $minutelyRate = $rate->minutely_rate;

        return new ParkingRates($hourlyRate, $minutelyRate);
    }
}

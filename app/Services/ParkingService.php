<?php

namespace App\Services;

use App\Domain\Parking\ParkingCostCalculator;
use App\Domain\Parking\ParkingPeriodData;
use App\Domain\Parking\ParkingRates;
use App\Domain\Parking\ParkingTimeCalculator;
use App\DTO\Parking\ParkingSessionData;
use App\Enums\ParkingSessionStatusEnum;
use App\Models\ParkingPeriod;
use App\Models\ParkingSession;
use App\Models\Rate;

readonly class ParkingService
{
    public function __construct(
        private ParkingTimeCalculator $timeCalculator,
        private ParkingCostCalculator $costCalculator
    ) {}
    public function store(ParkingSessionData $data): void
    {
        $parkingPeriod = $this->computeParkingPeriod($data->duration);
        $cost = $this->calculate($data);

        $parkingSession = ParkingSession::query()->create([
//            'start_at' => $parkingPeriod->startAt,
//            'end_at' => $parkingPeriod->endAt,
            'is_auto_renewal' => $data->isAutoRenewal,
//            'cost' => $cost,
            'vehicle_id' => $data->vehicleId,
            'zone_id' => $data->zoneId,
            'user_id' => $data->userId,
            'parking_session_status_id' => ParkingSessionStatusEnum::ACTIVE->value
        ]);

        ParkingPeriod::query()->create([
            'parking_session_id' => $parkingSession->id,
            'start_at' => $parkingPeriod->startAt,
            'end_at' => $parkingPeriod->endAt,
            'cost' => $cost,
            'user_id' => $data->userId
        ]);
    }

    private function getRates(int $zoneId, int $vehicleId): ParkingRates
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

    private function computeParkingPeriod(int $duration): ParkingPeriodData
    {
        $startAt = now();

        return new ParkingPeriodData($startAt, $startAt->copy()->addMinutes($duration));
    }

    public function calculate(ParkingSessionData $data): int
    {
        $parkingPeriod = $this->computeParkingPeriod($data->duration);

        $paidTime = $this->timeCalculator->calculate($parkingPeriod->startAt, $parkingPeriod->endAt);
        $rates = $this->getRates($data->zoneId, $data->vehicleId);

        return $this->costCalculator->calculate($rates, $paidTime);
    }
}

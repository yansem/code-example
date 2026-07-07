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
use Illuminate\Support\Facades\DB;

readonly class ParkingService
{
    public function __construct(
        private ParkingTimeCalculator $timeCalculator,
        private ParkingCostCalculator $costCalculator
    )
    {
    }

    public function store(ParkingSessionData $data): void
    {
        $parkingPeriodData = $this->computeParkingPeriod($data->duration);

        $cost = $this->calculateCost($data);
        $paidTime = $this->timeCalculator->calculate($parkingPeriodData->startAt, $parkingPeriodData->endAt);

        //todo: transaction
        $parkingSession = ParkingSession::query()->create([
            'duration' => $paidTime,
            'is_auto_renewal' => $data->isAutoRenewal,
            'vehicle_id' => $data->vehicleId,
            'zone_id' => $data->zoneId,
            'user_id' => $data->userId,
            'parking_session_status_id' => ParkingSessionStatusEnum::ACTIVE->value,
            'expires_at' => $parkingPeriodData->endAt
        ]);

        $parkingPeriod = ParkingPeriod::query()->create([
            'parking_session_id' => $parkingSession->id,
            'start_at' => $parkingPeriodData->startAt,
            'end_at' => $parkingPeriodData->endAt,
            'cost' => $cost,
            'source' => 'manual',
            'user_id' => $data->userId
        ]);

        $parkingSession->update(['current_parking_period_id' => $parkingPeriod->id]);

        auth()->user()->balance->decrement('balance', $cost);

    }

    public function cancel(ParkingSession $parkingSession)
    {
        $now = now()->startOfMinute();
        $refundAmount = $this->calculateCost(new ParkingSessionData(
            zoneId: $parkingSession->zone_id,
            vehicleId: $parkingSession->vehicle_id,
            duration: $now->diffInMinutes($parkingSession->expires_at)
        ));
        $parkingSession->update(['parking_session_status_id' => ParkingSessionStatusEnum::CANCELED->value]);
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
        $startAt = now()->startOfMinute();

        return new ParkingPeriodData($startAt, $startAt->copy()->addMinutes($duration));
    }

    public function calculateCost(ParkingSessionData $data): int
    {
        $parkingPeriod = $this->computeParkingPeriod($data->duration);

        $paidTime = $this->timeCalculator->calculate($parkingPeriod->startAt, $parkingPeriod->endAt);
        $rates = $this->getRates($data->zoneId, $data->vehicleId);

        return $this->costCalculator->calculate($rates, $paidTime);
    }

    public function renewParkingSessionById(int $sessionId): void
    {
        $session = ParkingSession::query()
            ->where('id', $sessionId)
            ->where('parking_session_status_id', ParkingSessionStatusEnum::ACTIVE->value)
            ->where('is_auto_renewal', true)
            ->with(['currentPeriod', 'user'])
            ->first();

        if (!$session) {
            return;
        }

        if ($session->expires_at > now()->startOfMinute()) {
            return;
        }

        $this->renewParkingSession($session);
    }

    private function renewParkingSession(ParkingSession $parkingSession): void
    {
        DB::transaction(function () use ($parkingSession) {

            $session = ParkingSession::query()
                ->where('id', $parkingSession->id)
                ->lockForUpdate()
                ->with(['currentPeriod', 'user'])
                ->first();

            if (!$session) {
                return;
            }

            if ($session->expires_at > now()->startOfMinute()) {
                return;
            }

            $lastPeriod = $session->currentPeriod;

            $duration = $session->user->auto_renewal_duration;
            $newEndAt = $lastPeriod->end_at->clone()->addMinutes($duration);

            $cost = $this->calculateCost(new ParkingSessionData(
                zoneId: $session->zone_id,
                vehicleId: $session->vehicle_id,
                duration: $duration
            ));

            $newPeriod = ParkingPeriod::create([
                'start_at' => $lastPeriod->end_at,
                'end_at' => $newEndAt,
                'cost' => $cost,
                'source' => 'auto',
                'parking_session_id' => $session->id,
                'user_id' => $session->user_id,
            ]);

            $session->update([
                'current_parking_period_id' => $newPeriod->id,
                'expires_at' => $newEndAt,
            ]);
        });
    }
}

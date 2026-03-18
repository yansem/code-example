<?php

namespace App\DTO\Parking;

final readonly class ParkingSessionData
{
    public function __construct(
        public int $zoneId,
        public int $vehicleId,
        public int $duration,
        public ?int $userId = null,
        public ?bool $isAutoRenewal = null
    ) {}
}

<?php

namespace App\DTO\Parking;

final readonly class ParkingData
{
    public function __construct(
        public int $zoneId,
        public int $vehicleId,
        public int $userId,
        public int $duration,
        public ?bool $isAutoRenewal = null
    ) {}
}

<?php

namespace App\DTO\Parking;

final readonly class CreateParkingData
{
    public function __construct(
        public int $zoneId,
        public int $vehicleId,
        public int $duration,
        public bool $isAutoRenewal
    ) {}
}

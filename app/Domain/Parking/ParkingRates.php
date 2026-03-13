<?php

namespace App\Domain\Parking;

final readonly class ParkingRates
{
    public function __construct(
        public int $hourlyRate,
        public int $minutelyRate,
    ) {}
}

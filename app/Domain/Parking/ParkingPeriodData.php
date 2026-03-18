<?php

namespace App\Domain\Parking;

use Carbon\CarbonInterface;

final readonly class ParkingPeriodData
{
    public function __construct(
        public CarbonInterface $startAt,
        public CarbonInterface $endAt,
    ) {}
}

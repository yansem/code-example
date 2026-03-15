<?php

namespace App\Domain\Parking;

use Carbon\CarbonInterface;

final readonly class ParkingPeriod
{
    public function __construct(
        public CarbonInterface $startAt,
        public CarbonInterface $endAt,
    ) {}
}

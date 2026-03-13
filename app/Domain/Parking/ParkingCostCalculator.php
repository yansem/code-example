<?php

namespace App\Domain\Parking;

class ParkingCostCalculator
{
    public function calculate(ParkingRates $rates, int $paidTime): int
    {
        if ($paidTime < 60) {
            return $rates->minutelyRate * $paidTime;
        }
        elseif ($paidTime === 60) {
            return $rates->hourlyRate;
        }
        else {
            return $rates->hourlyRate + ($paidTime - 60) * $rates->minutelyRate;
        }
    }
}

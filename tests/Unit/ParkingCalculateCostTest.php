<?php

use App\Domain\Parking\ParkingCostCalculator;
use App\Domain\Parking\ParkingRates;

test('parking cost calculation', function (ParkingRates $rates, int $paidTime, int $expected) {
    $calculator = new ParkingCostCalculator();

    expect($calculator->calculate($rates, $paidTime))
        ->toBe($expected);
})->with([
    '0 минут' => [
        new ParkingRates(hourlyRate: 500, minutelyRate: 10),
        0,
        0,
    ],

    'меньше часа (30 мин)' => [
        new ParkingRates(500, 10),
        30,
        300,                    // 30 × 10
    ],

    'ровно 59 минут' => [
        new ParkingRates(500, 10),
        59,
        590,
    ],

    'ровно 60 минут — используем hourlyRate' => [
        new ParkingRates(500, 10),
        60,
        500,
    ],

    '61 минута' => [
        new ParkingRates(500, 10),
        61,
        510,                    // 500 + 1 × 10
    ],

    '2 часа (120 мин)' => [
        new ParkingRates(500, 10),
        120,
        1100,                   // 500 + 60 × 10
    ],

    'другие ставки' => [
        new ParkingRates(hourlyRate: 800, minutelyRate: 15),
        75,
        1025,                   // 800 + 15 × 15
    ],
]);

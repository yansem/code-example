<?php

use App\Domain\Parking\ParkingTimeCalculator;
use Carbon\Carbon;

test('parking paid minutes calculation', function ($start, $end, $expected) {
    $startAt = Carbon::parse($start);
    $endAt = Carbon::parse($end);

    $calculator = new ParkingTimeCalculator();

    expect($calculator->calculate($startAt, $endAt))
        ->toBe($expected);
})->with([
    'inside paid window' => [
        '2025-01-01 19:30',
        '2025-01-01 20:00',
        30
    ],

    'overflow after paid hours' => [
        '2025-01-01 19:00',
        '2025-01-01 21:00',
        60
    ],

    'full paid day' => [
        '2025-01-01 03:00',
        '2025-01-01 21:00',
        720
    ],

    'exact one day span' => [
        '2025-01-01 08:00',
        '2025-01-02 08:00',
        720
    ],

    'two days span' => [
        '2025-01-01 08:00',
        '2025-01-03 08:00',
        1440
    ],
    'before paid hours' => [
        '2025-01-01 05:00',
        '2025-01-01 07:00',
        0
    ],
    'after paid hours' => [
        '2025-01-01 21:00',
        '2025-01-01 23:00',
        0
    ],
    'morning overlap' => [
        '2025-01-01 07:30',
        '2025-01-01 08:30',
        30
    ],
]);

<?php

namespace App\Domain\Parking;

use Carbon\CarbonInterface;

class ParkingTimeCalculator
{
    private const PAID_START_HOUR = 8;
    private const PAID_END_HOUR = 20;
    private const MINUTES_PER_DAY = 720; //todo может сломаться, если изменятся начало/окончание

    public function calculate(CarbonInterface $startAt, CarbonInterface $endAt): int
    {
        $startDay = $startAt->copy()->startOfDay();
        $endDay = $endAt->copy()->startOfDay();

        if ($startDay->eq($endDay)) {
            [$paidStart, $paidEnd] = $this->paidRange($startDay);

            $from = $startAt->max($paidStart);
            $to = $endAt->min($paidEnd);

            return $from->lt($to) ? $from->diffInMinutes($to) : 0;
        }

        $minutes = 0;

        [$paidStart, $paidEnd] = $this->paidRange($startDay);
        $from = $startAt->max($paidStart);

        if ($from->lt($paidEnd)) {
            $minutes += $from->diffInMinutes($paidEnd);
        }

        [$paidStart, $paidEnd] = $this->paidRange($endDay);
        $to = $endAt->min($paidEnd);

        if ($paidStart->lt($to)) {
            $minutes += $paidStart->diffInMinutes($to);
        }

        $fullDays = $startDay->diffInDays($endDay) - 1;

        if ($fullDays > 0) {
            $minutes += $fullDays * self::MINUTES_PER_DAY;
        }

        return $minutes;
    }

    private function paidRange(CarbonInterface $day): array
    {
        return [
            $day->copy()->setTime(self::PAID_START_HOUR, 0),
            $day->copy()->setTime(self::PAID_END_HOUR, 0),
        ];
    }
}

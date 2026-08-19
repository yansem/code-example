<?php

namespace App\Support;

final class MoneyFormatter
{
    public static function format(int $kopecks): string
    {
        return number_format($kopecks / 100, 2, '.', '');
    }
}

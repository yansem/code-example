<?php

namespace App\Enums;

enum ParkingSessionStatusEnum: int
{
    case ACTIVE = 1;
    case EXPIRED = 2;
    case STOPPED = 3;
}

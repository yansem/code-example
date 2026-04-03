<?php

namespace App\Policies;

use App\Enums\ParkingSessionStatusEnum;
use App\Models\ParkingSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ParkingSessionPolicy
{

    public function cancel(User $user, ParkingSession $parkingSession): Response
    {
        return $user->id === $parkingSession->user_id
            && $parkingSession->parking_session_status_id === ParkingSessionStatusEnum::ACTIVE->value
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}

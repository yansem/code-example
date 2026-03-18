<?php

namespace App\Jobs;

use App\Services\ParkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ParkingAutoRenewalJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $sessionId
    )
    {

    }

    public function uniqueId(): string
    {
        return 'parking-renewal-' . $this->sessionId;
    }

    public function uniqueFor(): int
    {
        return 60;
    }

    /**
     * Execute the job.
     */
    public function handle(ParkingService $parkingService): void
    {
        $parkingService->renewParkingSessionById($this->sessionId);
    }
}

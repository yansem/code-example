<?php

namespace App\Console\Commands;

use App\Enums\ParkingSessionStatusEnum;
use App\Jobs\ParkingAutoRenewalJob;
use App\Models\ParkingSession;
use App\Services\ParkingService;
use Illuminate\Console\Command;

class ParkingSessionAutoRenewalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parking-session:auto-renewal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto-renewal parking session';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ParkingSession::query()
            ->where('parking_session_status_id', ParkingSessionStatusEnum::ACTIVE->value)
            ->where('is_auto_renewal', true)
            ->where('expires_at', '<=', now()->startOfMinute())
            ->select('id')
            ->chunkById(500, function ($sessions) {
                foreach ($sessions as $session) {
                    ParkingAutoRenewalJob::dispatch($session->id);
                }
            });

        dump(now());
    }
}

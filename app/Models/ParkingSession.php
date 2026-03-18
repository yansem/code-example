<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkingSession extends Model
{
    protected $fillable = [
        'is_auto_renewal',
        'cost',
        'vehicle_id',
        'zone_id',
        'user_id',
        'parking_session_status_id',
        'current_parking_period_id',
        'expires_at'
    ];

    public function parkingPeriods(): HasMany
    {
        return $this->hasMany(ParkingPeriod::class);
    }

    public function currentPeriod(): BelongsTo
    {
        return $this->belongsTo(ParkingPeriod::class, 'current_parking_period_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

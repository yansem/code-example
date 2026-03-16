<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSession extends Model
{
    protected $fillable = [
        'is_auto_renewal',
        'cost',
        'vehicle_id',
        'zone_id',
        'user_id',
    ];
}

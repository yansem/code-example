<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    protected $fillable = [
        'start_at',
        'end_at',
        'is_auto_renewal',
        'cost',
        'vehicle_id',
        'zone_id',
        'user_id',
    ];
}

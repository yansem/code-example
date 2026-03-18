<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingPeriod extends Model
{
    protected $fillable = [
        'start_at',
        'end_at',
        'cost',
        'parking_session_id',
        'user_id',
        'source'
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];
}

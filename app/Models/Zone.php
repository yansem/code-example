<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zone extends Model
{
    use HasFactory;

    public function zoneCategory(): BelongsTo
    {
        return $this->belongsTo(ZoneCategory::class);
    }
}

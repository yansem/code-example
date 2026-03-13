<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Zone extends Model
{
    public function zoneCategory(): BelongsTo
    {
        return $this->belongsTo(ZoneCategory::class);
    }
}

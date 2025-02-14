<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrackingService extends Model
{
    use HasFactory;
    protected $table = 'tracking_service';
    protected $guarded = [];
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
    public function scheduleService()
    {
        return $this->hasOne(ScheduleService::class, 'id_service', 'id_service');
    }
}
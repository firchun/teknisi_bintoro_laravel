<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleService extends Model
{
    use HasFactory;
    protected $table = 'schedule_service';
    protected $guarded = [];

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_teknisi');
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}

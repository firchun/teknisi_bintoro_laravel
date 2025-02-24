<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function finished(): HasMany
    {
        return $this->hasMany(FinishedService::class, 'id_service');
    }
    public function schedule()
    {
        return $this->hasOne(ScheduleService::class, 'id_service');
    }
    public function finishedService()
    {
        return $this->hasOne(FinishedService::class, 'id_service');
    }
    public function tool()
    {
        return $this->hasMany(ToolService::class, 'id_service');
    }
    public static function checkFinish($id)
    {
        $checkFinish = FinishedService::where('id_service', $id);
        if ($checkFinish) {
            return 1;
        } else {
            return 0;
        }
    }
}
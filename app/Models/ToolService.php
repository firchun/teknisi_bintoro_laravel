<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ToolService extends Model
{
    use HasFactory;
    protected $table = 'tool_service';
    protected $guarded = [];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingService extends Model
{
    use HasFactory;
    protected $table = 'tracking_service';
    protected $guarded = [];
}

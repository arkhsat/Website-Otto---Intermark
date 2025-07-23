<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingZone extends Model
{
    use HasFactory;
    protected $fillable=[
        'zone_name',
        'notes',
        'parent_id',
    ];
}

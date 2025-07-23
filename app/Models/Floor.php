<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'zone',
        'floor_level',
        'notes',
        'status',
        'parent_id',
    ];

    public function zones()
    {
        return $this->hasOne('\App\Models\ParkingZone','id','zone');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'zone',
        'type',
        'floor',
        'notes',
        'is_available',
        'parent_id',
    ];

    public function zones()
    {
        return $this->hasOne('\App\Models\ParkingZone','id','zone');
    }

    public function types()
    {
        return $this->hasOne('\App\Models\VehicleType','id','type');
    }
    public function floors()
    {
        return $this->hasOne('\App\Models\Floor','id','floor');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingRate extends Model
{
    use HasFactory;
    protected $fillable=[
        'zone',
        'start_date',
        'due_date',
        'vehicle_type',
        'fix_rate',
        'hourly_rate',
        'notes',
        'parent_id',
    ];

    public function zones()
    {
        return $this->hasOne('\App\Models\ParkingZone','id','zone');
    }

    public function types()
    {
        return $this->hasOne('\App\Models\VehicleType','id','vehicle_type');
    }
}

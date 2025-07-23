<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;
    protected $fillable=[
        'zone',
        'title',
        'notes',
        'status',
        'parent_id',
    ];

    // public function zones()
    // {
    //     return $this->hasOne('\App\Models\ParkingZone','id','zone');
    // }
}

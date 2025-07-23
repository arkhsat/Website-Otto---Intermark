<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'zone',
        // 'type',
        // 'floor',
        // 'slot',
        'vehicle_no',
        'rfid_no',
        'name',
        'phone_number',
        'notes',
        'membertype',
        'parent_id',
    ];

    // public function zones()
    // {
    //     return $this->hasOne('\App\Models\ParkingZone','id','zone');
    // }

    public function types()
    {
        return $this->hasOne('\App\Models\VehicleType','id','type');
    }
    // public function floors()
    // {
    //     return $this->hasOne('\App\Models\Floor','id','floor');
    // }

    // public function slots()
    // {
    //     return $this->hasOne('\App\Models\ParkingSlot','id','slot');
    // }

    public function membertypes()
    {
        return $this->hasOne('\App\Models\MemberType','id','membertype');
    }

}

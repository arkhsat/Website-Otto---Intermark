<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parking extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'phone_number',
        'parking_id',
        'zone',
        'type',
        'floor',
        'slot',
        'vehicle_number',
        'entry_date',
        'entry_time',
        'exit_date',
        'exit_time',
        'total_duration',
        'amount',
        'payment_status',
        'status',
        'notes',
        'parent_id',
    ];

    public static $status=[
        'Park',
        'Leave'
    ];

    public static $paymentStatus=[
        'Unpaid',
        'Paid'
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

    public function slots()
    {
        return $this->hasOne('\App\Models\ParkingSlot','id','slot');
    }


    public static function paymentCalculation($id,$duration)
    {
        $parking=Parking::find($id);

        $parkingRate=ParkingRate::where('parent_id',parentId())->where('zone',$parking->zone)->where('vehicle_type',$parking->type)
            ->where('start_date','<=',date('Y-m-d'))
            ->where('due_date','>=',date('Y-m-d'))->first();
        if(!empty($parkingRate)){
            if($duration>=1){
                $total=$duration*$parkingRate->hourly_rate;
            }else{
                $total=$duration*$parkingRate->fix_rate;
            }
        }else{
            $parkingOldRate=ParkingRate::where('parent_id',parentId())->where('zone',$parking->zone)->latest()->first();
            if($duration>=1){
                $total=$duration*!empty($parkingOldRate->hourly_rate)?$parkingOldRate->hourly_rate:0;
            }else{
                $total=$duration*!empty($parkingOldRate->fix_rate)?$parkingOldRate->fix_rate:0;
            }
        }
        return $total;

    }
}

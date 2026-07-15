<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    protected $fillable=[
        'room_no',
        'guest_name',
        'check_in',
        'check_out',
        'plat_no',
        'uidno',
        'status',
        'parent_id',
    ];

    public function hotelType()
    {
        return $this->belongsTo(HotelType::class, 'type');
    }
   
}
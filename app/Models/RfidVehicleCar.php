<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidVehicleCar extends Model
{
    use HasFactory;

    protected $table = 'rfid_car'; // ✅ tambahkan baris ini

    protected $fillable = [
        'rfid_no',
    ];
}

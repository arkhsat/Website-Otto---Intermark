<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfidVehicleBlueBird extends Model
{
    use HasFactory;

    protected $table = 'blue_bird'; // ✅ tambahkan baris ini

    protected $fillable = [
        'uid_no',
    ];
}


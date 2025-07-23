<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingGate extends Model
{
    use HasFactory;
    protected $fillable=[
        'gate_name',
        'notes',
        'parent_id',
    ];
}

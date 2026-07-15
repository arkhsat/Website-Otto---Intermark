<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelType extends Model
{
    protected $table = 'hotels_type';

    protected $fillable = [
        'type'
    ];

    // use HasFactory;

    public function hotels()
    {
        return $this->hasMany(Hotel::class, 'type');
    }
}

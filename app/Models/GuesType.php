<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuesType extends Model
{
    use HasFactory;
    protected $table = 'hotels_type';
    public $timestamps = false;
    protected $fillable=[
        'type'

    ];
}


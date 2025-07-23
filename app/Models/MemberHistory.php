<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberHistory extends Model
{
    use HasFactory;

    protected $table = 'member_history';

    protected $fillable = [
        'member_id',
        'product_code',
        'price',
        'month',
        'newcard',
        'biaya',
        'status',
        'created_at',
        'updated_at',
    ];

}

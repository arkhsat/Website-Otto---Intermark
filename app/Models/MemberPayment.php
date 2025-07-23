<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'phone'
    ];

    // Relasi dengan Payment
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}

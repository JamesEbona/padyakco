<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mechanic_id',
        'first_name',
        'last_name',
        'phone_number',
        'repair_type',
        'location',
        'booking_time',
        'longhitude',
        'latitude',
        'notes',
        'status',
        'repair_fee',
        'transportation_fee',
        'additional_fee',
        'total_fee'
    ];

    protected $dates = [
        'booking_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function mechanic()
    {
        return $this->belongsTo(User::class,'mechanic_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDaySales extends Model
{
    use HasFactory;

    protected $table = 'booking_daily_sales';

    protected $fillable = [
        'day',
        'profit',
        'after'
    ];
}

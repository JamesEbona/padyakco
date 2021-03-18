<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingMonthSales extends Model
{
    use HasFactory;

    protected $table = 'booking_monthly_sales';

    protected $fillable = [
        'month',
        'profit',
        'after'
    ];
}

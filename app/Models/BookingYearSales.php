<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingYearSales extends Model
{
    use HasFactory;

    protected $table = 'booking_yearly_sales';

    protected $fillable = [
        'year',
        'profit',
    ];
}

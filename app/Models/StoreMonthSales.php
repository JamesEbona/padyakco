<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreMonthSales extends Model
{
    use HasFactory;

    protected $table = 'store_monthly_sales';

    protected $fillable = [
        'month',
        'profit',
        'after'
    ];
}

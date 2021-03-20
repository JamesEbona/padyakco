<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreDaySales extends Model
{
    use HasFactory;

    protected $table = 'store_daily_sales';

    protected $fillable = [
        'day',
        'profit',
        'after'
    ];
}

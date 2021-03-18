<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreYearSales extends Model
{
    use HasFactory;

    protected $table = 'store_yearly_sales';

    protected $fillable = [
        'year',
        'profit',
    ];
}

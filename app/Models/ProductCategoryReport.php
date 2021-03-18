<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryReport extends Model
{
    use HasFactory;

    protected $table = 'prod_cat_report';

    protected $fillable = [
        'title',
        'number'
    ];
}

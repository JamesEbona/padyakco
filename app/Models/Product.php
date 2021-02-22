<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'brand',
        'category_id',
        'subcategory_id',
        'quantity',
        'price',
        'delivery_fee',
        'provincial_delivery_fee',
        'rating',
        'status',
        'description',
        'image1',
        'image2',
        'image3'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    
}

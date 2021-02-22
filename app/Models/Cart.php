<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_quantity',
        'total_price'
    ];

    public function cartitems()
    {
        return $this->hasMany(CartItem::class);
    }
}

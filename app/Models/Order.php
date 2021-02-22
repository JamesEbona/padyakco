<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quantity_total',
        'sub_total',
        'grand_total',
        'shipping',
        'first_name',
        'last_name',
        'email',
        'address1',
        'address2',
        'city',
        'province',
        'postal_code',
        'phone_number',
        'status'
    ];

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address1',
        'address2',
        'city',
        'province',
        'postal_code',
        'phone_number',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

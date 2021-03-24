<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'code',
        'category',
        'value',
        'percent_off',
        'status'
    ];

    public static function findByCode($code){
        return self::where('code', $code)->first();
    }

    public function discount($total)
    {
        if ($this->type == 'Fixed') {
            return $this->value;
        } elseif ($this->type == 'Percent') {
            return round(($this->percent_off / 100) * $total);
        } else {
            return 0;
        }
    }
}

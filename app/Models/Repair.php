<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $fillable = [
        'basic_fee',
        'expert_fee',
        'upgrade_fee',
        'caloocan_fee',
        'malabon_fee',
        'navotas_fee',
        'valenzuela_fee',
        'quezon_fee',
        'marikina_fee',
        'pasig_fee',
        'taguig_fee',
        'makati_fee',
        'manila_fee',
        'makati_fee',
        'mandaluyong_fee',
        'sanjuan_fee',
        'pasay_fee',
        'paranaque_fee',
        'laspinas_fee',
        'muntinlupa_fee'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideCategory extends Model
{
    use HasFactory;

    protected $table = 'guide_categories';

    protected $fillable = [
        'title',
        'description'
    ];

    public function guides()
    {
        return $this->hasMany(Guide::class);
    }

}

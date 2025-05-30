<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $casts = [
        'social' => 'array',
        'gallery' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

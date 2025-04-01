<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $casts = [
        'contacts' => 'array',
        'gallery' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}

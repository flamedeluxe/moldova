<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $casts = [
        'blocks' => 'json',
        'gallery' => 'array',
        'social' => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeActiveSorted($query)
    {
        return $query->where('active', 1)->orderBy('sort');
    }
}

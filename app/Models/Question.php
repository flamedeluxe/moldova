<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $casts = [
        'blocks' => 'json',
    ];
    
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

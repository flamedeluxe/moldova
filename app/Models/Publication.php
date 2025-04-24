<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $casts = [
        'blocks' => 'json',
        'gallery' => 'array'
    ];

    protected $appends = [
        'date'
    ];

    public static function getTypeOptions(): array
    {
        return [
            'news' => 'Новость',
            'event' => 'Афиша',
        ];
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::get(fn () => self::getTypeOptions()[$this->type] ?? 'Неизвестно');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!is_string($model->title)) {
                return;
            }
            $model->slug = \Str::slug($model->title);
        });

        static::updating(function ($model) {
            if (!is_string($model->title)) {
                return;
            }
            $model->slug = \Str::slug($model->title);
        });
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->published_at)->translatedFormat('d M Y');
    }
}

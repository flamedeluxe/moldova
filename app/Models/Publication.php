<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $casts = [
        'blocks' => 'json',
        'gallery' => 'array'
    ];

    public static function getTypeOptions(): array
    {
        return [
            'news' => 'Новость',
            'article' => 'Статья',
            'event' => 'Мероприятие',
        ];
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::get(fn () => self::getTypeOptions()[$this->type] ?? 'Неизвестно');
    }
}

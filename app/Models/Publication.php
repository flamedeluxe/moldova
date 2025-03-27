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
            'article' => 'Статья',
            'event' => 'Мероприятие',
        ];
    }

    protected function typeLabel(): Attribute
    {
        return Attribute::get(fn () => self::getTypeOptions()[$this->type] ?? 'Неизвестно');
    }

    public static function getCityOptions(): array
    {
        return [
            'Москва' => 'Москва',
            'Санкт-Петербург' => 'Санкт-Петербург',
            'Воронеж' => 'Воронеж',
            'Екатеринбург' => 'Екатеринбург',
            'Иваново' => 'Иваново',
            'Калуга' => 'Калуга',
            'Калининград' => 'Калининград',
            'Карелия' => 'Карелия',
            'Краснодар' => 'Краснодар',
            'Кострома' => 'Кострома',
            'Курск' => 'Курск',
            'Крым' => 'Крым',
            'Липецк' => 'Липецк',
            'Мегион' => 'Мегион',
            'Мурманск' => 'Мурманск',
            'Нижний Новгород' => 'Нижний Новгород',
            'Ноябрьск' => 'Ноябрьск',
            'Подольск' => 'Подольск',
            'Ростов-на-Дону' => 'Ростов-на-Дону',
            'Рязань' => 'Рязань',
            'Смоленск' => 'Смоленск',
            'Сочи' => 'Сочи',
            'Ставрополь' => 'Ставрополь',
            'Тула' => 'Тула',
            'Ярославль' => 'Ярославль',
            'Коломна' => 'Коломна',
        ];
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

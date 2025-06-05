<?php

namespace App\Services\Site;

class MangoOfficeError
{
    public static function error($code)
    {
        $errors = [
            3101 => 'Неверный метод запроса',
            3102 => 'Неверная подпись',
            3105 => 'Неверный API ключ',
        ];

        return [
            'code' => $code,
            'message' => $errors[$code] ?? 'Неизвестная ошибка'
        ];
    }
} 
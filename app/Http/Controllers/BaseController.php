<?php

namespace App\Http\Controllers;

use DateTime;

class BaseController extends Controller
{
    function parseDateRange($dateRange): ?array
    {
        $months = [
            'янв' => 1, 'фев' => 2, 'мар' => 3, 'апр' => 4, 'май' => 5, 'июн' => 6,
            'июл' => 7, 'авг' => 8, 'сен' => 9, 'окт' => 10, 'ноя' => 11, 'дек' => 12
        ];

        // Декодируем URL-строку и убираем лишние пробелы
        $dateRange = trim(urldecode($dateRange));

        // Исправленное регулярное выражение
        preg_match('/(\d{1,2})\s*(\w{3})\s*-\s*(\d{1,2})\s*(\w{3})/ui', $dateRange, $matches);

        if (!$matches) {
            return null; // Если не удалось разобрать, вернем null
        }

        [$full, $day1, $month1, $day2, $month2] = $matches;

        $year = date('Y');

        // Приводим названия месяцев к нижнему регистру и ищем в массиве
        $month1 = $months[mb_strtolower($month1, 'UTF-8')];
        $month2 = $months[mb_strtolower($month2, 'UTF-8')];

        // Если второй месяц раньше первого, значит год следующий
        $year2 = ($month2 < $month1) ? $year + 1 : $year;

        $dateStart = date('Y-m-d', strtotime("$year-$month1-$day1"));
        $dateEnd = date('Y-m-d', strtotime("$year2-$month2-$day2"));

        return [$dateStart, $dateEnd];
    }

}

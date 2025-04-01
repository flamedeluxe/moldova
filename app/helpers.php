<?php

if (!function_exists('highlightSearch')) {
    function highlightSearch($text, $search)
    {
        if (!$search) return $text; // Если пустой запрос — ничего не выделяем

        $words = explode(" ", trim($search)); // Разбиваем запрос на слова
        $words = array_filter($words); // Убираем пустые значения

        if (empty($words)) return $text; // Если нет слов — не меняем текст

        // Экранируем спецсимволы и формируем regex для каждого слова
        $pattern = '/\b(' . implode('|', array_map('preg_quote', $words)) . ')\b/ui';

        // Заменяем найденные слова на <span class="highlight">...</span>
        return preg_replace($pattern, '<i class="highlight">$1</i>', $text);
    }
}

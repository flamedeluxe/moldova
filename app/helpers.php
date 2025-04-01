<?php

if (!function_exists('highlightSearch')) {
    function highlightSearch($text, $search)
    {
        if (!$search) return $text; // Если пустой запрос — ничего не выделяем

        // Разбиваем запрос на слова, фильтруем пустые значения
        $words = array_filter(explode(" ", trim($search)));

        if (empty($words)) return $text; // Если нет слов — не меняем текст

        // Создаём регулярку для поиска частей слов (не только полные слова!)
        $pattern = '/' . implode('|', array_map('preg_quote', $words)) . '/ui';

        // Оборачиваем найденные фрагменты в <i class="highlight">
        return preg_replace($pattern, '<i class="highlight">$0</i>', $text);
    }
}

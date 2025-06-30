<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Services\Site\MangoOffice;

$mango = new MangoOffice('8v7lygho7jb61aa7e7gwlqz6horeuqe2', 'sux7mpqilsripo5gbjok484gxb10h6ua');

try {
    $result = $mango->sendCall(
        '908', // Внутренний номер из второй ВАТС
        '79311071200', // Номер для звонка
        null, // Номер вызывающего абонента (опционально)
        'test_' . time() // Уникальный ID команды
    );
    echo "Результат отправки звонка:\n";
    var_dump($result);
} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
} 
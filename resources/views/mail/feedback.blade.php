@component('mail::message')
# Новый запрос на помощь юриста

Имя: {{ $name }}
Телефон: {{ $phone }}
Текст: {{ $text }}

Спасибо,<br>
{{ config('app.name') }}
@endcomponent

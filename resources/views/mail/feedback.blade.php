@component('mail::message')
# Новый запрос на помощь юриста

Имя: {{ $name }} <br>
Телефон: {{ $phone }} <br>
Текст: {{ $text }} <br>

Спасибо,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Восстановление пароля

Ваш новый пароль для входа: {{ $password }}

Спасибо,<br>
{{ config('app.name') }}
@endcomponent

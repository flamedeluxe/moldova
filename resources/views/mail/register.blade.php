@component('mail::message')
# Добро пожаловать!

Спасибо за регистрацию! Чтобы подтвердить ваш аккаунт, перейдите по следующей ссылке:

@component('mail::button', ['url' => $link])
    Подтвердить аккаунт
@endcomponent

Или скопируйте ссылку и вставьте в браузер:
[{{ $link }}]({{ $link }})

Спасибо,<br>
{{ config('app.name') }}
@endcomponent

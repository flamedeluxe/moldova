@component('mail::message')
    # Новая публикация

    Заголовок: {{ $title }}
    Город: {{ $city }}
    Менеджер: {{ $author }}

    Спасибо,
    {{ config('app.name') }}
@endcomponent

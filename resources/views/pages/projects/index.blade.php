@extends('layouts.base')

@section('content')
    <div class="p-projects">
        <div class="container">
            <div class="p-projects__top">
                <div class="p-projects__top-title">Наши проекты</div>
                {{--
                <div class="events__select">
                    <div>
                        <input type="text" name="date" placeholder="Выбрать даты" required>
                    </div>
                </div>
                --}}
            </div>

            @foreach($projects as $item)
            <a href="{{ $item->link ?? route('projects.show', $item->slug) }}" class="d-block mb-4">
                <picture>
                    <source media="(max-width: 768px)" srcset="{{ asset('storage/' . $item->image_m) }}">
                    <img src="{{ asset('storage/' . $item->banner) }}" alt="">
                </picture>
            </a>
            @endforeach

            <div class="p-projects__bottom">
                <div class="events__select">
                    <div>
                        <img src="img/calendar.svg" alt="">
                        <span>Календарь мероприятий</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

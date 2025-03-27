@extends('layouts.base')

@section('content')
    <div class="events">
        <div class="container">
            <div class="p-projects__top">
                <div class="p-projects__top-title">Новости</div>
                <div class="events__select">
                    <div>
                        <input type="text" name="date" placeholder="Выбрать даты" required>
                    </div>
                </div>
            </div>

            <div class="row gx-4">
                @foreach($news as $item)
                <div class="col-12 col-sm-4">
                    <a href="{{ route('publications.show', $item->slug) }}" class="item">
                        <div class="item__img">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                            @if($item->category)
                            <div class="item__img-badge">
                                {{ $item->category }}
                            </div>
                            @endif
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                {{ $item->date }}
                            </div>
                            <div class="item__info-title">
                                {{ $item->title }}
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="events__more">
                <button class="btn btn--default">
                    Предыдущие новости
                </button>
            </div>
        </div>
    </div>

    <div class="events bg--gray">
        <div class="container">
            <div class="events__top">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="events__top-title">
                            <span>Ближайшие мероприятия</span>
                            <a href="">Москва</a>
                        </div>
                        <div class="events__top-more">
                            <img src="img/loc.svg" alt="">
                            <span>Найти свой город</span>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="events__tags justify-content-end">
                            <div class="tag active"><span>Все</span></div>
                            @foreach($categories as $item)
                            <div class="tag"><span>{{ $item }}</span></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach($events as $item)
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                {{ $item->date }}
                            </div>
                            <div class="item__info-title">
                                {{ $item->title }}
                            </div>
                            <div class="item__info-text">
                                {!! $item->introtext !!}
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="events__more">
                <button class="btn btn--default">
                    Следующие события
                </button>
            </div>
        </div>
    </div>
@endsection

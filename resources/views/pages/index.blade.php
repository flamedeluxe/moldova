@extends('layouts.base')

@section('content')
    <div class="hero">
        <div class="container">
            <div class="keen-slider">
                <div class="keen-slider__slide slide">
                    <div class="img">
                        <img src="img/hero.jpg" alt="">
                    </div>
                    <div class="caption">
                        <div class="caption__left">
                            <div class="caption__info">
                                <div class="caption__info-badge">
                                    Традиции
                                </div>
                                <div class="caption__info-date">
                                    27 января
                                </div>
                            </div>
                            <div class="caption__title">
                                Молдавские колядки
                            </div>
                        </div>
                        <div class="caption__right">
                            Экопарк «Рождествено», <br>
                            Московская область
                        </div>
                    </div>
                </div>
                <div class="keen-slider__slide slide">
                    <div class="img">
                        <img src="img/hero.jpg" alt="">
                    </div>
                    <div class="caption">
                        <div class="caption__left">
                            <div class="caption__info">
                                <div class="caption__info-badge">
                                    Традиции
                                </div>
                                <div class="caption__info-date">
                                    27 января
                                </div>
                            </div>
                            <div class="caption__title">
                                Молдавские колядки
                            </div>
                        </div>
                        <div class="caption__right">
                            Экопарк «Рождествено», <br>
                            Московская область
                        </div>
                    </div>
                </div>
            </div>

            <div class="keen-slider__controls">
                <button class="keen-slider-arrow keen-slider-arrow--left">
                    <img src="img/prev.svg" alt="">
                </button>
                <div class="keen-slider-dots"></div>
                <button class="keen-slider-arrow keen-slider-arrow--right">
                    <img src="img/next.svg" alt="">
                </button>
            </div>
        </div>
    </div>

    <div class="events" x-data="news()">
        <div class="container">
            <div class="row gx-4">
                @foreach($news as $idx => $item)
                <div class="col-12 col-sm-4">
                    <a href="{{ route('publications.show', $item->slug) }}" class="item">
                        @if($idx == 1 || $idx == 5)
                            <div class="item__caption">
                                <div class="item__caption-title">
                                    {{ $item->title }}
                                </div>
                                <div class="item__caption-date">
                                    {{ $item->date }}
                                </div>
                            </div>
                        @else
                            <div class="item__img">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                <div class="item__img-badge">
                                    {{ $item->category }}
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    {{ $item->date }}
                                </div>
                                <div class="item__info-title">
                                    {{ $item->title }}
                                </div>
                            </div>
                        @endif
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

    <div class="projects">
        <div class="title">
            <span>Наши проекты</span>
        </div>
        <div class="container">
            <div class="keen-slider">
                @foreach($projects as $item)
                <div class="keen-slider__slide slide">
                    <a href="{{ route('projects.show', $item->slug) }}">
                        <picture>
                            <source media="(max-width: 768px)" srcset="{{ asset('storage/' . $item->image_m) }}">
                            <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->title }}">
                        </picture>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="keen-slider__controls">
                <button class="keen-slider-arrow keen-slider-arrow--left">
                    <img src="img/prev.svg" alt="">
                </button>
                <div class="keen-slider-dots"></div>
                <button class="keen-slider-arrow keen-slider-arrow--right">
                    <img src="img/next.svg" alt="">
                </button>
            </div>
        </div>
    </div>

    <div class="events bg--gray" x-data="events()">
        <div class="container">
            <div class="events__top">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="events__top-title">
                            <span>Афиша</span>
                            <a href="">Москва</a>
                        </div>
                        <div class="events__top-more">
                            <img src="img/loc.svg" alt="">
                            <span>Найти свой город</span>
                        </div>
                        <div class="events__tags">
                            <div class="tag active">
                                <span>Все</span>
                            </div>
                            <div class="tag">
                                <span>Культура</span>
                            </div>
                            <div class="tag">
                                <span>Спорт</span>
                            </div>
                            <div class="tag">
                                <span>Образование</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="events__dates">
                            <div class="date">
                                <div class="day">
                                    27
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                        </div>
                        <div class="events__select">
                            <div>
                                <input type="text" name="date" placeholder="Выбрать даты" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                27 января
                            </div>
                            <div class="item__info-title">
                                Концерт «Кто помнит, тот не знает поражения»
                            </div>
                            <div class="item__info-text">
                                ул. Волхонка, д. 15, Зал Церковных Соборов Храма Христа Спасителя.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                27 января
                            </div>
                            <div class="item__info-title">
                                Концерт «Кто помнит, тот не знает поражения»
                            </div>
                            <div class="item__info-text">
                                ул. Волхонка, д. 15, Зал Церковных Соборов Храма Христа Спасителя.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                27 января
                            </div>
                            <div class="item__info-title">
                                Концерт «Кто помнит, тот не знает поражения»
                            </div>
                            <div class="item__info-text">
                                ул. Волхонка, д. 15, Зал Церковных Соборов Храма Христа Спасителя.
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="events__more">
                <button class="btn btn--default">
                    Следующие события
                </button>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.base')

@section('content')
    <div class="p-region">
        <div class="p-region__hero" style="background-image: url(img/region.jpg);">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-4 order-2 order-sm-1 d-flex flex-column justify-content-between">
                        <div class="wrapper">
                            <div class="p-region__title">
                                {{ $city->title }}
                            </div>
                            @if($city->social)
                            <div class="p-region__controls">
                                <div class="p-region__controls-social">
                                    @foreach($city->social as $item)
                                        <a href="{{ $item['link'] }}"><img src="img/{{ $item['service'] }}.svg" alt=""></a>
                                    @endforeach
                                </div>
                                <div class="p-region__controls-phone">
                                    <a href="tel:{{ str_replace(['-', ' ', '(', ')'], '', $city->phone) }}">{{ $city->phone }}</a>
                                </div>
                            </div>
                            @endif
                            @if($city->address)
                            <div class="p-region__info">
                                <div class="p-region__info-title">
                                    {{ $city->address }}
                                </div>
                                <div class="p-region__info-text">
                                    {{ $city->metro }}
                                </div>
                            </div>
                            @endif
                            @if($city->time)
                            <div class="p-region__info">
                                <div class="p-region__info-title">
                                    {{ $city->time }}
                                </div>
                                <div class="p-region__info-text">
                                    График работы
                                </div>
                            </div>
                            @endif
                        </div>
                        @if($user)
                        <div class="wrapper">
                            <div class="p-region__boss">
                                <div class="p-region__boss-img">
                                    <img src="{{ isset($user->avatar) ? asset('storage/' . $user->avatar) : '' }}" alt="{{ $user->name }}">
                                </div>
                                <div class="p-region__boss-caption">
                                    <div class="p-region__boss-caption__title">
                                        Руководитель центра
                                    </div>
                                    <div class="p-region__boss-caption__name">
                                        {{ $user->fullname }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-12 col-sm-8 order-1 order-sm-2">
                        <div class="p-region__slider">
                            @if($city->gallery)
                            <div class="keen-slider">
                                @foreach($city->gallery as $idx => $item)
                                <div class="keen-slider__slide slide">
                                    <img src="{{ asset('storage/' . $item) }}" alt="{{ $city->title }}">
                                </div>
                                @endforeach
                            </div>
                            <div class="keen-slider__controls">
                                <button class="keen-slider-arrow keen-slider-arrow--left">
                                    <img src="img/prev.svg" alt="">
                                </button>
                                <button class="keen-slider-arrow keen-slider-arrow--right">
                                    <img src="img/next.svg" alt="">
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="events">
        <div class="container">
            <div class="events__top">
                <div class="row align-items-center space-between">
                    <div class="col-6 col-sm-6">
                        <div class="events__top-title">
                            <span>Новости</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <a href="{{ route('publications.index') }}" class="events__top-all">
                            <span>Все новости</span>
                            <img src="img/more.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row gx-4">
                @foreach($news as $item)
                    <div class="col-12 col-sm-4">
                        <a href="{{ route('publications.show', $item->slug) }}" class="item">
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
        </div>
    </div>

    <div class="events bg--gray">
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
                @foreach($events as $item)
                    <div class="col-12 col-sm-4">
                        <a href="{{ route('publications.show', $item->slug) }}" class="item">
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

    <div class="projects">
        <div class="title">
            <span>Наши проекты</span>
        </div>
        <div class="container">
            <div class="keen-slider">
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm1.jpg">
                        <img src="img/p1.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm2.jpg">
                        <img src="img/p2.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm3.jpg">
                        <img src="img/p3.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm1.jpg">
                        <img src="img/p1.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm2.jpg">
                        <img src="img/p2.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm3.jpg">
                        <img src="img/p3.png" alt="">
                    </picture>
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

<script>
    function newsSlider()
    {
        return {

        }
    }
</script>
@endsection

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
                        @if($city->boss_name)
                        <div class="wrapper">
                            <div class="p-region__boss">
                                @if($city->boss_image)
                                <div class="p-region__boss-img">
                                    <img src="{{ asset('storage/' . $city->boss_image) }}" alt="{{ $city->boss_name }}">
                                </div>
                                @endif
                                <div class="p-region__boss-caption">
                                    <div class="p-region__boss-caption__title">
                                        Руководитель центра
                                    </div>
                                    <div class="p-region__boss-caption__name">
                                        {{ $city->boss_name }}
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

    <div class="events" x-data="news()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="events__top">
                <div class="row align-items-center space-between">
                    <div class="col-6 col-sm-6">
                        <div class="events__top-title">
                            <span>Новости</span>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <a href="{{ route('news.index') }}" class="events__top-all">
                            <span>Все новости</span>
                            <img src="img/more.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row gx-4">
                <template x-for="item in items" x-key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`publications/${item.slug}`" class="item">
                            <div class="item__img">
                                <img :src="`storage/${item.image}`" :alt="item.title">
                                <div class="item__img-badge" x-html="item.category" x-show="item.category"></div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date" x-html="item.date">
                                </div>
                                <div class="item__info-title" x-html="item.title">
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>

    @include('components.events', ['disableCity' => 1, 'title' => 'Ближайшие мероприятия'])

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
@endsection

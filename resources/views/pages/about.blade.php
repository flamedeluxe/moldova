@extends('layouts.base')

@section('content')
    <div class="p-about">
        @foreach($page->blocks as $block)

            @switch($block['type'])
                @case('heading')
                    <{{ $block['data']['level'] }} class="p-about__title wrapper">
                            {{ $block['data']['text'] }}
                    </{{ $block['data']['level'] }}>
                    @break
                @case('gallery')
                    <div class="keen-slider">
                        @foreach($block['data']['gallery'] as $idx => $item)
                        <div class="keen-slider__slide slide">
                            <img src="{{ asset('storage/' . $item) }}" alt="">
                        </div>
                        @endforeach
                    </div>
                    @break
                @case('paragraph')
                    <div class="p-about__block">
                        <div class="wrapper">
                            {!! $block['data']['content'] !!}
                        </div>
                    </div>
                    @break
                @case('blockquote')
                    <div class="p-about__blockquote">
                        <div class="wrapper">
                            <blockquote>
                                {{ $block['data']['content'] }}
                            </blockquote>
                        </div>
                    </div>
                    @break
                @case('image_right')
                    <div class="p-about__block --with-image-right">
                        <div class="wrapper">
                            <div class="left">
                                {!! $block['data']['content'] !!}
                            </div>
                            <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                        </div>
                    </div>
                    @break
                @case('image_left')
                    <div class="p-about__block --with-image-left">
                        <div class="wrapper">
                            <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                            <div class="right">
                                {!! $block['data']['content'] !!}
                            </div>
                        </div>
                    </div>
                    @break
                @case('block')
                    <div class="p-about__block --background">
                        <div class="wrapper">
                            <p>
                                <strong>
                                    {{ $block['data']['title'] }}
                                </strong>
                            </p>
                            {!! $block['data']['content'] !!}
                        </div>
                    </div>
                    @break
                @case('cards')
                    <div class="p-about__items wrapper">
                        <div class="p-about__items-title">
                            <span>{{ $block['data']['title'] }}</span>
                        </div>

                        <div class="keen-slider partners-slider">
                            @foreach($block['data']['items'] as $item)
                            <div class="keen-slider__slide slide">
                                <div class="p-about__items-item">
                                    <div class="p-about__items-item-img">
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}">
                                    </div>
                                    <div class="p-about__items-item-name">
                                        {{ $item['title'] }}
                                    </div>
                                    <div class="p-about__items-item-position">
                                        {{ $item['text'] }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @break
                @case('logos')
                    <div class="p-about__items wrapper">
                        <div class="p-about__items-title">
                            <span>{{ $block['data']['title'] }}</span>
                        </div>

                        <div class="row g-2">
                            @foreach($block['data']['items'] as $item)
                            <div class="col-4 col-sm-3">
                                <div class="p-about__items-item">
                                    <div class="p-about__items-item-img">
                                        <img src="{{ asset('storage/' . $item['image']) }}" alt="">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @break
            @endswitch
        @endforeach
    </div>

    <div class="projects bg--gray">
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
@endsection

@extends('layouts.base')

@section('content')
    <div class="p-page {{ $project->page_class }}">
        <div class="p-page__hero" style="background-image: url({{ asset('storage/' . $project->image_back) }});">
            <div class="container">
                @if($project->image)
                <img src="{{ asset('storage/' . $project->image) }}" class="p-page__hero-img" alt="">
                @endif
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="wrapper">
                            <div class="p-page__top">
                                <div class="p-page__back">
                                    <a style="color:{{ $project->text_color }}" href="{{ route('projects.index') }}">
                                        <svg width="13" height="13">
                                            <g fill="currentColor" fill-rule="evenodd">
                                                <circle opacity=".2" cx="6.5" cy="6.5" r="6.5"/>
                                                <path d="m3.346 6.84-.021-.037-.046-.11-.021-.094a.654.654 0 0 1 0-.198l.02-.089.022-.062.031-.065.045-.07.064-.075 2.6-2.6a.65.65 0 0 1 .92.92L5.47 5.849l3.63.001a.65.65 0 1 1 0 1.3l-3.632-.001L6.96 8.64a.65.65 0 0 1 .068.84l-.068.08a.65.65 0 0 1-.92 0l-2.6-2.6-.042-.047-.052-.073Z" fill-rule="nonzero" opacity=".8"/>
                                            </g>
                                        </svg>
                                        <span>Наши проекты</span>
                                    </a>
                                </div>
                                <div class="p-page__title">
                                    {{ $project->title }}
                                </div>
                                <div class="p-page__text">
                                    {{ $project->introtext }}
                                </div>
                            </div>
                            <div class="p-page__bottom">
                                <div class="p-page__email">
                                    <a href="mailto:{{ $project->email }}">{{ $project->email }}</a>
                                </div>
                                <div class="p-page__phone">
                                    <a href="tel:{{ str_replace([' ', '-', ')', '('], '', $project->phone) }}">{{ $project->phone }}</a>
                                    <div>Приемная</div>
                                </div>
                                <div class="p-page__social">
                                    @foreach($project->social as $idx => $item)
                                    <a href="{{ $item['link'] }}"><img src="img/{{ $item['service'] }}.svg" alt=""></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    @if($project->gallery)
                        <div class="p-page__slider keen-slider mb-4">
                            @foreach($project->gallery as $idx => $item)
                                <div class="keen-slider__slide">
                                    <img src="{{ asset('storage/' . $item) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                        @if(count($project->gallery) > 1)
                            <div class="keen-slider__controls">
                                <button class="keen-slider-arrow keen-slider-arrow--left">
                                    <img src="img/prev.svg" alt="">
                                </button>
                                <div class="keen-slider-dots"></div>
                                <button class="keen-slider-arrow keen-slider-arrow--right">
                                    <img src="img/next.svg" alt="">
                                </button>
                            </div>
                        @endif
                    @endif
                    @foreach($project->blocks as $block)
                        @switch($block['type'])
                            @case('heading')
                                <div class="p-page__head">
                                    {!! $block['data']['text'] !!}
                                </div>
                                @break
                            @case('paragraph')
                                <div class="p-page__content">
                                    {!! $block['data']['content'] !!}
                                </div>
                                @break
                            @case('blockquote')
                                <div class="p-page__content">
                                    <blockquote>
                                        {!! $block['data']['content'] !!}
                                    </blockquote>
                                </div>
                                @break
                            @case('block')
                                <div class="p-page__block">
                                    <div class="p-page__block-title">
                                        {!! $block['data']['title'] !!}
                                    </div>
                                    <div class="p-page__block-content">
                                        {!! $block['data']['content'] !!}
                                    </div>
                                </div>
                                @break
                            @case('person')
                                <div class="p-page__boss">
                                    <div class="p-page__boss-title">
                                        {{ $block['data']['title'] }}
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-3">
                                            <div class="p-page__boss-img">
                                                <img
                                                    src="{{ asset('storage/' . $block['data']['image']) }}"
                                                    alt="{{ $block['data']['fio'] }}"
                                                >
                                            </div>
                                            <div class="wrap">
                                                @if($block['data']['phone'])
                                                    <a
                                                        href="tel:{{ str_replace([' ', '-', ')', '(', ''], '', $block['data']['phone']) }}"
                                                        class="p-page__boss-item"
                                                    >
                                                        <span>{{ $block['data']['phone'] }}</span>
                                                        <img src="img/phone3.svg" alt="">
                                                    </a>
                                                @endif
                                                @if($block['data']['email'])
                                                    <a
                                                        href="emailto:{{ $block['data']['email'] }}"
                                                        class="p-page__boss-item"
                                                    >
                                                        <span>{{ $block['data']['email'] }}</span>
                                                        <img src="img/email2.svg" alt="">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-9">
                                            <div class="p-page__boss-name">
                                                {{ $block['data']['fio'] }}
                                            </div>
                                            @if($block['data']['text'])
                                                <div class="p-page__boss-text">
                                                    {{ $block['data']['text'] }}
                                                </div>
                                            @endif
                                            @if($block['data']['quote'])
                                                <div class="p-page__boss-quote">
                                                    <blockquote>
                                                        {{ $block['data']['quote'] }}
                                                    </blockquote>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @break
                            @case('banner')
                                <div class="p-page__promo">
                                    <a href="{{ $block['data']['link'] }}">
                                        <picture>
                                            <source media="(max-width: 768px)"
                                                    srcset="{{ asset('storage/' . $block['data']['image_m']) }}"
                                            >
                                            <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                                        </picture>
                                    </a>
                                </div>
                                @break
                        @endswitch
                    @endforeach



                </div>
                <div class="col-12 col-sm-4">
                    <div class="p-page__aside">
                        <div class="p-page__aside-title">
                            <div>Новости</div>
                            <a href="{{ route('publications.index') }}">
                                <span>Все</span>
                                <img src="img/v.svg" alt="Все новости">
                            </a>
                        </div>
                        <div class="p-page__aside-content">
                            @foreach($news as $item)
                                <a href="{{ route('publications.show', $item->slug) }}" class="item">
                                    <div class="item__title">
                                        {{ $item->title }}
                                    </div>
                                    <div class="item__date">
                                        {{ $item->date }}
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <div class="p-page__aside-title">
                            <div>Мероприятия</div>
                            {{--
                            <div class="events__select">
                                <div>
                                    <span>календарь</span>
                                    <img src="img/v.svg" alt="">
                                    <input type="text" name="date" placeholder="Выбрать даты" required>
                                </div>
                            </div>
                            --}}
                        </div>
                        <div class="p-page__aside-content">
                            @foreach($events as $item)
                                <a href="{{ route('publications.show', $item->slug) }}" class="item">
                                    <div class="item__img">
                                        <div class="item__img-badge">{{ $item->category }}</div>
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="">
                                    </div>
                                    <div class="item__date">
                                        {{ $item->date }}
                                    </div>
                                    <div class="item__title">
                                        {{ $item->title }}
                                    </div>
                                    <div class="item__text">
                                        {{ $item->introtext }}
                                    </div>
                                    {{--
                                    <div class="item__loc">
                                        <img src="img/loc.svg" alt="">
                                        <span>Охотный ряд, 1</span>
                                    </div>
                                    --}}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

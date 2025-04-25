@extends('layouts.base')

@section('content')
    <div class="p-about p-text">
        <h1 class="p-about__title wrapper mb-0">
            {!! $page->title !!}
        </h1>
        @foreach($page->blocks as $block)
            @switch($block['type'])
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
                        @if(!empty($block['data']['link']))
                            <a href="{{ $block['data']['link'] }}">
                                <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                        @endif
                    </div>
                </div>
                @break
            @case('image_left')
                <div class="p-about__block --with-image-left">
                    <div class="wrapper">
                        @if(!empty($block['data']['link']))
                            <a href="{{ $block['data']['link'] }}">
                                <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                            </a>
                        @else
                            <img src="{{ asset('storage/' . $block['data']['image']) }}" alt="">
                        @endif
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
@endsection

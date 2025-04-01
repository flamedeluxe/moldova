@extends('layouts.base')

@section('content')
    <div class="p-page mt-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="p-page__back">
                        <a href="{{ route('companies.index') }}">
                            <img src="img/back2.svg" alt="{{ $company->title }}">
                            <span>Предприятия</span>
                        </a>
                    </div>
                    <div class="p-page__h1">
                        <h1 class="p-page__h1-title">{{ $company->title }}</h1>
                    </div>
                    <div class="p-page__introtext">
                        <p>
                            {{ $company->introtext }}
                        </p>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <div class="p-page__address">
                                {{ $company->address }}
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="p-page__links">
                                <div>
                                    <img src="img/phone-call.svg" alt="Телефон">
                                    <span>{{ $company->phone }}</span>
                                </div>
                                <div>
                                    <img src="img/mail3.svg" alt="E-mail">
                                    <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                                </div>
                                <div>
                                    <img src="img/site.svg" alt="Сайт">
                                    <a href="{{ $company->site }}">{{ $company->site }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($company->gallery)
                        <div class="p-page__slider keen-slider">
                            @foreach($company->gallery as $image)
                            <div class="keen-slider__slide">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $item->title }}">
                            </div>
                            @endforeach
                        </div>
                        <div class="keen-slider__controls">
                            <button class="keen-slider-arrow keen-slider-arrow--left">
                                <img src="img/prev.svg" alt="prev">
                            </button>
                            <div class="keen-slider-dots"></div>
                            <button class="keen-slider-arrow keen-slider-arrow--right">
                                <img src="img/next.svg" alt="next">
                            </button>
                        </div>
                    @elseif($company->image)
                        <div class="p-page__content2">
                            <img
                                style="object-fit: cover;width: 100%;height: 100%;"
                                src="{{ asset('storage/' . $company->image) }}"
                                alt="{{ $company->title }}"
                            >
                        </div>
                    @endif
                    <div class="p-page__content2">
                        {!! $company->content !!}
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="p-page__aside">
                        <div class="p-page__aside-title">
                            <div>Еще предприятия</div>
                            <a href="{{ route('companies.index') }}">
                                <span>Все</span>
                                <img src="img/v.svg" alt="">
                            </a>
                        </div>

                        <div class="p-products__items">
                            @foreach($companies as $item)
                                <div class="item">
                                    <div class="item__img">
                                        <a href="{{ route('companies.show', $item->slug) }}">
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="">
                                        </a>
                                    </div>
                                    <div class="item__subtitle">
                                        {{ $item->way }}
                                    </div>
                                    <div class="item__title">
                                        <a href="{{ route('companies.show', $item->slug) }}">{{ $item->title }}</a>
                                    </div>
                                    <div class="item__text">
                                        {{ $item->introtext }}
                                    </div>
                                    <div class="item__address">
                                        {{ $item->address }}
                                    </div>
                                    <div class="item__links">
                                        <div>
                                            <img src="img/phone-call.svg" alt="Телефон">
                                            <span>{{ $item->phone }}</span>
                                        </div>
                                        <div>
                                            <img src="img/mail3.svg" alt="E-mail">
                                            <a href="mailto:{{ $item->email }}">{{ $item->email }}</a>
                                        </div>
                                        <div>
                                            <img src="img/site.svg" alt="Сайт">
                                            <a href="{{ $item->site }}" target="_blank">{{ $item->site }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

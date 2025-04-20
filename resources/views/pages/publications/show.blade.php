    @extends('layouts.base')

@section('content')
    <div class="p-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="p-page__back">
                        <a href="{{ route('publications.index') }}">
                            <img src="img/back2.svg" alt="">
                            <span>Новости</span>
                        </a>
                    </div>
                    <div class="p-page__h1">
                        <h1>{{ $publication->title }}</h1>
                    </div>
                    <div class="p-page__date">
                        {{ $publication->date }}
                    </div>
                    @if($publication->gallery)
                        <div class="p-page__slider keen-slider">
                            @foreach($publication->gallery as $idx => $item)
                            <div class="keen-slider__slide">
                                <img src="{{ asset('storage/' . $item) }}" alt="">
                            </div>
                            @endforeach
                        </div>
                        @if(count($publication->gallery))
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
                    @else
                    <div class="p-page__slider">
                        <img src="{{ asset('storage/' . $publication->image) }}" alt="{{ $publication->title }}">
                    </div>
                    @endif
                    <div class="p-page__content2">
                        {!! $publication->content !!}
                    </div>
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

    <style>
        .p-page {
            padding-top: 3rem;
        }
    </style>
@endsection

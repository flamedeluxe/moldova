@extends('layouts.base')

@section('content')
    <div class="hero">
        <div class="container">
            <div class="keen-slider">
                @foreach($slides as $slide)
                    <div class="keen-slider__slide slide">
                        <div class="img">
                            <img src="{{ asset('storage/' . $slide['image']) }}" alt="">
                        </div>
                        <div class="caption">
                            <div class="caption__left">
                                <div class="caption__info">
                                    <div class="caption__info-badge">
                                        {{ $slide['badge'] }}
                                    </div>
                                    <div class="caption__info-date">
                                        {{ Carbon\Carbon::parse($slide['date'])->translatedFormat('d M Y') }}
                                    </div>
                                </div>
                                <div class="caption__title">
                                    {{ $slide['title'] }}
                                </div>
                            </div>
                            <div class="caption__right">
                                {{ $slide['text'] }}
                            </div>
                        </div>
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

    <div class="events" x-data="news()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="row gx-4">
                <template x-for="(item, idx) in items" :key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`publications/${item.slug}`" class="item">
                            <div class="item__caption" x-show="idx == 1 || idx == 5">
                                <div class="item__caption-title" x-text="item.title">
                                </div>
                                <div class="item__caption-date" x-text="item.date">
                                </div>
                            </div>

                            <div class="item__img" x-show="idx != 1 && idx != 5">
                                <img :src="`storage/${item.image}`" alt="">
                                <div class="item__img-badge" x-text="item.category">
                                </div>
                            </div>
                            <div class="item__info" x-show="idx != 1 && idx != 5">
                                <div class="item__info-date" x-text="item.date">
                                </div>
                                <div class="item__info-title" x-text="item.title">
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>
            <div class="events__more" x-show="total > items.length">
                <button class="btn btn--default" @click.prevent="nextPage">
                    Предыдущие новости
                </button>
            </div>
        </div>
    </div>

    @include('components.projects')

    @include('components.events')
@endsection

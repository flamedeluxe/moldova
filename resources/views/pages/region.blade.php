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
                        <a href="{{ route('publications.index') }}" class="events__top-all">
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

    <div class="events bg--gray" x-data="events()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
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
                            <template x-for="(item, idx) in categories" :key="idx">
                                <div
                                    class="tag"
                                    :class="category === item ? 'active' : ''"
                                    @click="category = item; get()"
                                    x-text="item">
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="events__dates">
                            @foreach($eventDates as $date)
                                <div class="date">
                                    <div class="day">
                                        {{ $date->day }}
                                    </div>
                                    <div class="month">
                                        {{ $date->locale('ru')->monthName|substr(0, 3) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="events__select">
                            <div>
                                <input type="text" x-model="date" name="date" @change="filter" placeholder="Выбрать даты" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <template  x-for="item in items" x-key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`publications/${item.slug}`" class="item">
                            <div class="item__img">
                                <img :src="`storage/${item.image}`" :alt="item.title">
                            </div>
                            <div class="item__info">
                                <div class="item__info-date" x-html="item.date">
                                </div>
                                <div class="item__info-title" x-html="item.title">
                                </div>
                                <div class="item__info-text" x-html="item.introtext">
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>

            <div class="events__more" x-show="items.length > total">
                <button class="btn btn--default" @click.prevent="nextPage">
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

<script>
    function news() {
        return {
            items: @json($news),
            loading: false,
            total: @json($news_total),
            date: '',
            page: 1,
            error: '',
            filter() {
                this.date = document.querySelector('[x-model="date"]').value;
                this.get();
            },
            nextPage() {
                this.page++;
                this.get();
            },
            async get() {
                this.loading = true;
                this.error = '';
                const response = await fetch(`/publications?type=news&page=${this.page}&date=${this.date}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .finally(() => {
                        this.loading = false;
                    });

                if(response.ok) {
                    this.items = response.json()
                }
            }
        }
    }
    function events() {
        return {
            items: @json($events),
            categories: @json($categories),
            loading: false,
            total: @json($events_total),
            date: '',
            page: 1,
            category: '',
            error: '',
            init() {
                this.category = 'Все';
            },
            filter() {
                this.date = document.querySelector('[x-model="date"]').value;
                this.category = ''; // Очистка категории при фильтрации
                this.get(); // Перезагрузка данных
            },
            nextPage() {
                this.page++; // Переход на следующую страницу
                this.get(); // Получение данных для следующей страницы
            },
            async get() {
                this.loading = true;
                this.error = '';
                const response = await fetch(`/publications?type=events&page=${this.page}&category=${this.category}&date=${this.date}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .finally(() => {
                        this.loading = false;
                    });

                if (response.ok) {
                    this.items = await response.json(); // Обновление списка данных
                } else {
                    this.error = 'Ошибка загрузки данных';
                }
            }
        }
    }
</script>
@endsection

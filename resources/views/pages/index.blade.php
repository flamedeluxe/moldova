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
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="row gx-4">
                <template x-for="(item, idx) in items" :key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`publicaions/${item.slug}`" class="item">
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

    <div class="events bg--gray" x-data="events()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="events__top">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="events__top-title">
                            <span>Ближайшие мероприятия</span>
                            <a href="" data-modal="#modal_city" x-text="city"></a>
                        </div>
                        <div class="events__top-more" data-modal="#modal_city">
                            <img src="img/loc.svg" alt="">
                            <span>Найти свой город</span>
                        </div>

                        <div class="modal modal__city" id="modal_city">
                            <div class="wrap">
                                <div class="modal__close">
                                    &times;
                                </div>
                                <div class="modal__content">
                                    <div class="dropdown__cities">
                                        <ul>
                                            <li><a href="#" @click.prevent="city = 'Москва'; get()">Москва</a></li>
                                            <li><a href="#" @click.prevent="city = 'Санкт-Петербург'; get()">Санкт-Петербург</a></li>
                                        </ul>
                                    </div>
                                    <div class="dropdown__list">
                                        <ul>
                                            <template x-for="city in cities" :key="city.id">
                                                <li>
                                                    <a
                                                        @click.prevent="city = city.title; get()"
                                                        :href="`region/${city.slug}`"
                                                        x-text="city.title">
                                                    </a>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="events__tags justify-content-end">
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
                </div>
            </div>

            <div class="row">
                <div class="col-12" x-cloak x-show="items.length === 0">Событий не найдено</div>
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
                    Следующие события
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
                        const r = await response.json();
                        this.items = r.data;
                        this.total = r.total;
                    }
                }
            }
        }
        function events() {
            return {
                items: @json($events),
                cities: @json($cities),
                categories: @json($categories),
                loading: false,
                total: @json($events_total),
                page: 1,
                city: '{{ session()->get('city') ?? 'Москва' }}',
                category: '',
                error: '',
                init() {
                    this.category = 'Все';
                },
                filter() {
                    this.category = ''; // Очистка категории при фильтрации
                    this.get(); // Перезагрузка данных
                },
                nextPage() {
                    this.page++; // Переход на следующую страницу
                    this.get(); // Получение данных для следующей страницы
                },
                async get() {
                    closeModals();
                    this.loading = true;
                    this.error = '';
                    const response = await fetch(`/publications?type=events&page=${this.page}&category=${this.category}&city=${this.city}`, {
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
                        const r = await response.json();
                        this.items = r.data;
                        this.total = r.total;
                    } else {
                        this.error = 'Ошибка загрузки данных';
                    }
                }
            }
        }
    </script>
@endsection

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
        <div class="container">
            <div class="row gx-4">
                @foreach($news as $idx => $item)
                <div class="col-12 col-sm-4">
                    <a href="{{ route('publications.show', $item->slug) }}" class="item">
                        @if($idx == 1 || $idx == 5)
                            <div class="item__caption">
                                <div class="item__caption-title">
                                    {{ $item->title }}
                                </div>
                                <div class="item__caption-date">
                                    {{ $item->date }}
                                </div>
                            </div>
                        @else
                            <div class="item__img">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}">
                                <div class="item__img-badge">
                                    {{ $item->category }}
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    {{ $item->date }}
                                </div>
                                <div class="item__info-title">
                                    {{ $item->title }}
                                </div>
                            </div>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
            <div class="events__more">
                <button class="btn btn--default">
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
                            <a href="">Москва</a>
                        </div>
                        <div class="events__top-more">
                            <img src="img/loc.svg" alt="">
                            <span>Найти свой город</span>
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
                <template  x-for="item in items" x-key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`news/${item.slug}`" class="item">
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
        function events() {
            return {
                items: @json($events),
                categories: @json($categories),
                loading: false,
                total: @json($events_total),
                page: 1,
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
                    this.loading = true;
                    this.error = '';
                    const response = await fetch(`/publications?type=events&page=${this.page}&category=${this.category}`, {
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

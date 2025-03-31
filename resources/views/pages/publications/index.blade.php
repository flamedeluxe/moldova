@extends('layouts.base')

@section('content')
    <div class="events" x-data="news()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="p-projects__top">
                <div class="p-projects__top-title">Новости</div>
                <div class="events__select">
                    <div>
                        <input type="text" x-model="date" @change="filter" placeholder="Выбрать даты" required>
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
            <div class="events__more" x-show="items.length > total">
                <button class="btn btn--default" @click.prevent="nextPage">
                    Следующие новости
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

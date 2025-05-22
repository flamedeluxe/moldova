@extends('layouts.base')

@section('content')
    <div class="events" x-data="events()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="events__top">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="events__top-title">
                            <span>{{ $title ?? 'Афиша' }}</span>
                            @if(!isset($disableCity))
                                <a href="" data-modal="#modal_city" x-text="city"></a>
                            @endisset
                        </div>
                        @if(!isset($disableCity))
                            <div class="events__top-more" data-modal="#modal_city">
                                <img src="img/loc.svg" alt="">
                                <span>Найти свой город</span>
                            </div>
                        @endisset
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
                            <template x-for="(item, idx) in dates" :key="idx">
                                <div class="date" @click="selectDate(item)">
                                    <div class="day" x-text="item.day">
                                    </div>
                                    <div class="month" x-text="item.month">
                                    </div>
                                </div>
                            </template>
                        </div>
                        <div class="events__select">
                            <div>
                                <input type="text" x-model="date" readonly name="date" @change="filter" placeholder="Выбрать даты" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <template  x-for="item in items" x-key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`events/${item.slug}`" class="item">
                            <div class="item__img">
                                <img :src="`storage/${item.image}`" :alt="item.title">
                            </div>
                            <div class="item__info-date">
                                <span x-text="item.date"></span>
                                <span x-text="item.city" x-show="item.city"></span>
                            </div>
                            <div class="item__info">
                                <div class="item__info-title" x-html="item.title">
                                </div>
                                <div class="item__info-text" x-html="item.introtext">
                                </div>
                            </div>
                        </a>
                    </div>
                </template>
            </div>

            <div class="events__more" x-show="total > items.length">
                <button class="btn btn--default" @click.prevent="nextPage">
                    Предыдущие события
                </button>
            </div>
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
                            <template x-for="item in cities" :key="item.id">
                                <li>
                                    <a
                                        @click.prevent="city = item.title; get()"
                                        :href="`region/${item.slug}`"
                                        x-text="item.title">
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function events() {
            return {
                items: @json($events),
                cities: @json($cities),
                categories: @json($categories),
                loading: false,
                total: @json($events_total),
                dates: @json($dates ?? []),
                page: 1,
                city: '{{ session()->get('city') ?? 'Москва' }}',
                date: '',
                category: '',
                error: '',
                init() {
                    this.category = 'Все';
                },
                filter() {
                    this.$nextTick(() => {
                        this.category = '';
                        this.date = document.querySelector('[x-model="date"]').value;
                        this.get();
                    })
                },
                nextPage() {
                    this.page++;
                    this.get();
                },
                async selectCity(city) {
                    await this.get();
                    this.city = city.title;
                },
                selectDate(date) {
                    this.date = `${date.day} ${date.month}-${date.day} ${date.month}`
                    this.get();
                },
                async get() {
                    closeModals();
                    this.loading = true;
                    this.error = '';
                    const params = new URLSearchParams({
                        type: 'events',
                        page: this.page,
                        category: this.category,
                        city: this.city,
                        date: this.date
                    });
                    const response = await fetch(`/publications?${params.toString()}`, {
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
                        this.categories = r.categories;
                    } else {
                        this.error = 'Ошибка загрузки данных';
                    }
                }
            }
        }
    </script>


    @include('components.projects')
@endsection

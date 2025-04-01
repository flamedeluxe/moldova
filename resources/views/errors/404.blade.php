@extends('layouts.base')

@section('content')
    <div class="p-404">
        <div class="container">
            <div class="p-404__caption">
                <div class="p-404__caption-title">
                    К сожалению, <br>
                    страница не найдена…
                </div>
                <div class="p-404__caption-text">
                    Возможно страница была удалена, у нее изменился <br>
                    адрес или она временно недоступна
                </div>
                <div class="p-404__caption-back">
                    <a href="/" class="btn btn--default">
                        <img src="img/more-inverted.svg" alt="">
                        <span>Вернуться на главную</span>
                    </a>
                </div>
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
@endsection

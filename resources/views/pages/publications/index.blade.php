@extends('layouts.base')

@section('content')
    <div class="events" x-data="news()">
        <div class="container" :class="loading ? 'opacity-50' : ''">
            <div class="p-projects__top">
                <div class="p-projects__top-title">Новости</div>
                <div class="events__select">
                    <div>
                        <input type="text" x-model="date" readonly name="date" @change="filter" placeholder="Выбрать даты" required>
                    </div>
                </div>
            </div>

            <div class="row gx-4">
                <div class="col-12" x-show="!items.length">Новостей не найдено</div>
                <template x-for="item in items" x-key="item.id">
                    <div class="col-12 col-sm-4">
                        <a :href="`publications/${item.slug}`" class="item">
                            <div class="item__img">
                                <img :src="`storage/${item.image}`" :alt="item.title">
                                <div class="item__img-badge" x-html="item.category" x-show="item.category"></div>
                            </div>
                            <div class="item__info-date">
                                <span x-text="item.date"></span>
                                <span x-text="item.city" x-show="item.city"></span>
                            </div>
                            <div class="item__info">
                                <div class="item__info-title" x-html="item.title">
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

    @include('components.events', ['title' => 'Ближайшие мероприятия'])

    @include('components.projects')
@endsection

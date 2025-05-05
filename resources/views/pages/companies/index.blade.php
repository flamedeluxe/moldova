@extends('layouts.base')

@section('content')
    <div class="p-products" x-data="companies()">
        <div class="container">
            <div class="p-products__title">
                <strong>Сделано молдаванами</strong> в России
            </div>
            <div class="p-products__filters">
                <div class="row">
                    <div class="col-12 col-sm-4 input">
                        <select x-model="way" @change="filter()">
                            <option value="" selected>Отрасль</option>
                            <template x-for="item in ways" :key="item">
                                <option :value="item" x-text="item"></option>
                            </template>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 input">
                        <select x-model="city" @change="filter()">
                            <option value="" selected>Регион</option>
                            <template x-for="item in cities" :key="item.id">
                                <option :value="item.title" x-text="item.title"></option>
                            </template>
                        </select>
                    </div>
                    <div class="col-12 col-sm-4 input">
                        <input type="text" x-model="query" @input.debounce="filter()" placeholder="Поиск по сайту…">
                    </div>
                </div>
            </div>

            <div class="p-products__items">
                <div class="row gx-4">
                    <div x-show="total === 0" class="mb-5 pb-5">
                        Результатов не найдено
                    </div>
                    <template x-for="item in items" :key="item.id">
                        <div class="col-12 col-sm-4">
                            <div class="item">
                                <div class="item__img">
                                    <a :href="`companies/${item.slug}`">
                                        <img :src="`storage/${item.image}`" alt="">
                                    </a>
                                </div>
                                <div class="item__subtitle" x-text="item.way">
                                </div>
                                <div class="item__title">
                                    <a :href="`companies/${item.slug}`" x-text="item.title"></a>
                                </div>
                                <div class="item__text" x-text="item.introtext">
                                </div>
                                <div class="item__address" x-text="item.address">
                                </div>
                                <div class="item__links">
                                    <div x-show="item.phone">
                                        <img src="img/phone-call.svg" alt="">
                                        <span x-text="item.phone"></span>
                                    </div>
                                    <div x-show="item.email">
                                        <img src="img/mail3.svg" alt="">
                                        <a :href="`mailto:${item.email}`" x-text="item.email"></a>
                                    </div>
                                    <div x-show="item.site">
                                        <img src="img/site.svg" alt="">
                                        <a :href="item.site" x-text="item.site"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="events__more mb-5" x-show="total > items.length">
                    <button class="btn btn--default" @click.prevent="nextPage">
                        Показать больше
                    </button>
                </div>
            </div>
        </div>
    </div>

<script>
    function companies() {
        return {
            way: '',
            city: '',
            query: '',
            loading: false,

            ways: @json($ways),
            cities: @json($citiesAll),

            items: @json($companies),
            total: @json($total),

            page: 1,

            filter() {
                this.get();
            },

            nextPage() {
                this.page++;
                this.get();
            },

            async get() {
                this.loading = true;
                this.error = '';
                const params = new URLSearchParams({
                    way: this.way,
                    city: this.city,
                    query: this.query,
                    page: this.page
                });
                const response = await fetch(`/companies?${params.toString()}`, {
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
                    this.total = r.total;
                    console.log(r)
                    if(this.page === 1) {
                        this.items = r.data;
                    }
                    else {
                        this.items.push(...r.data);
                    }
                } else {
                    this.error = 'Ошибка загрузки данных';
                }
            }
        }
    }
</script>
@endsection

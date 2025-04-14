@extends('layouts.base')

@section('content')
    <main x-data="account()">
        <div class="p-account">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <div class="p-account__title" x-text="profile.fullname">
                        </div>
                        <div class="p-account__verified" x-show="profile.card" x-cloak>
                            <img src="img/verified.svg" alt="">
                            <span>Гражданин Молдовы</span>
                        </div>
                        <div class="p-account__info">
                            <div class="item">
                                <div class="item__title">
                                    Регион
                                </div>
                                <div class="item__text" x-text="profile.region">
                                </div>
                            </div>
                            <div class="item">
                                <div class="item__title">
                                    E-mail
                                </div>
                                <div class="item__text" x-text="profile.email">
                                </div>
                            </div>
                            <div class="item">
                                <div class="item__title">
                                    Номер телефона
                                </div>
                                <div class="item__text">
                                    <span x-text="profile.phone"></span>
                                    <a x-show="profile.phone == ''" x-cloak href="" data-modal="#modal_profile">указать</a>
                                </div>
                            </div>
                        </div>
                        <div class="p-account__social">
                            @foreach($profile->socials as $item)
                                @if(str_contains($item, 'vk.com'))
                                <a href="{{ $item }}">
                                    <img src="img/vk.svg" alt="">
                                    <span>Вконтакте</span>
                                </a>
                                @elseif(str_contains($item, 't.me'))
                                    <a href="{{ $item }}">
                                        <img src="img/te.svg" alt="">
                                        <span>Вконтакте</span>
                                    </a>
                                @elseif(str_contains($item, 'ok.ru'))
                                    <a href="{{ $item }}">
                                        <img src="img/ok.svg" alt="">
                                        <span>Вконтакте</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="col-12 col-sm-4" x-show="profile.count < 8" x-cloak>
                        <div class="p-account__bar">
                            <div class="p-account__bar-line" :style="`width: ${100 / 8 * profile.count}%`"></div>
                        </div>
                        <div class="p-account__text">
                            Чтобы начать полноценно пользоваться сервисом, <strong>заполните профиль и получите
                                350 баллов в подарок</strong>
                        </div>
                        <div class="p-account__btn">
                            <button class="btn btn--default" data-modal="#modal_profile">
                                Заполнить профиль
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4" x-show="profile.count >= 8" x-cloak>
                        <div class="p-account__edit">
                            <a href="" data-modal="#modal_profile">Редактировать</a>
                        </div>
                        <div class="p-account__edit">
                            <a href="{{ route('account.logout') }}">Выйти</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-card">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-8">
                        <div class="p-card__info">
                            <img class="p-card__info-img" src="img/card2.png" alt="">
                            <div class="p-card__info-caption" x-show="profile.card" x-cloak>
                                <div class="wrap">
                                    <div class="p-card__info-code">
                                        Карта № <span x-text="profile.card_number"></span>
                                    </div>
                                    <div class="p-card__info-refresh" @click="refresh">
                                        <img src="img/refresh.svg" :class="loading ? 'loading' : ''" alt="">
                                        <span>Обновить данные</span>
                                    </div>
                                </div>
                                <div class="wrap">
                                    <div class="p-card__info-bill">
                                        <span x-text="profile.bill"></span> баллов
                                    </div>
                                    <div class="p-card__info-subtext">
                                        за активность в мероприятиях
                                    </div>
                                    <div class="p-card__info-button">
                                        <a href="" class="btn btn--default">
                                            Выбрать поощрение
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="p-card__info-caption" x-show="!profile.card" x-cloak>
                                <div class="p-card__info-title">
                                    Получите карту гражданина Молдовы в РФ
                                </div>
                                <div class="p-card__info-text">
                                    Участвуйте в мероприятиях культурно-образовательного центра Молдовы, зарабатывайте баллы и получайте поощрения
                                </div>
                                <div class="p-card__info-btn">
                                    <a href="//mdcard.ru/" class="btn btn--default">
                                        Оформить карту
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="p-card__contacts">
                            <div class="p-card__contacts-title">
                                <strong>Культурно-образовательный центр Молдовы</strong> в Москве
                            </div>
                            <div class="p-card__top">
                                <div class="p-card__top-social">
                                    <a href="">
                                        <img src="img/vk.svg" alt="">
                                    </a>
                                    <a href="">
                                        <img src="img/te.svg" alt="">
                                    </a>
                                </div>
                                <div class="p-card__top-phone">
                                    <a href="">+7 (495) 540-45-15</a>
                                </div>
                            </div>
                            <div class="p-card__address">
                                <div>ул. Солянка, д. 1/2, стр. 1</div>
                                <a href="">
                                    <span>На карте</span>
                                    <svg width="12" height="7" xmlns="http://www.w3.org/2000/svg">
                                        <path d="m8.44 7-.686-.674 2.386-2.34H0v-.972h10.14L7.754.668 8.44 0 12 3.5z" fill="#ED1846" fill-rule="nonzero"/>
                                    </svg>
                                </a>
                            </div>
                            <div class="p-card__links">
                                <a href="{{ route('faq') }}">Вопросы и ответы</a>
                                <a href="#faq">Юридическая помощь</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="events">
            <div class="container">
                <div class="p-projects__top p-acccount__top">
                    <div class="p-projects__top-title">Посещайте мероприятия</div>
                    <div class="events__select">
                        <div>
                            <input type="text" x-model="date" placeholder="Выбрать даты" required>
                        </div>
                        <div class="keen-slider__controls">
                            <button class="keen-slider-arrow keen-slider-arrow--left">
                                <img src="img/prev.svg" alt="">
                            </button>
                            <button class="keen-slider-arrow keen-slider-arrow--right">
                                <img src="img/next.svg" alt="">
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-acccount__events keen-slider">
                    <template x-for="item in items" x-key="item.id">
                        <div class="keen-slider__slide">
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

        <div class="gifts">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="item">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal__profile" id="modal_profile">
            <div class="wrap">
                <div class="modal__close">
                    <img src="img/close.svg" alt="">
                </div>
                <div class="modal__content">
                    @include('components.forms.account')
                </div>
            </div>
        </div>
    </main>

    <script>
        function account() {
            return {
                items: @json($events),
                total: @json($events_total),
                page: 1,
                city: @json($profile->city),
                category: '',
                error: '',
                profile: @json($profile),
                loading: false,
                cities: @json($citiesAll),
                form: {
                    surname: '',
                    name: '',
                    patronymic: '',
                    birthday: '',
                    phone: '',
                    email: '',
                    region: '',
                    socials: ['']
                },
                alertSuccess: false,
                token: '',
                errors: {},

                date: '',
                headers: {},

                init() {
                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    this.form = @json($profile);
                    if (!Array.isArray(this.form.socials) || this.form.socials.length === 0) {
                        this.form.socials = [''];
                    }
                    this.headers = {
                        "Content-Type": "application/json",
                        'X-Requested-With': 'XMLHttpRequest',
                        "X-CSRF-TOKEN": this.token
                    }
                },
                filter() {
                    this.category = '';
                    this.date = document.querySelector('[x-model="date"]').value;
                    this.getEvents();
                },
                nextPage() {
                    this.page++;
                    this.getEvents();
                },
                addSocial() {
                    this.form.socials.unshift('');
                },
                removeSocial(index) {
                    if (this.form.socials.length > 1) {
                        this.form.socials.splice(index, 1);
                    }
                },
                async getEvents() {
                    closeModals();
                    this.loading = true;
                    this.error = '';
                    const params = new URLSearchParams({
                        type: 'events',
                        page: this.page,
                        date: this.date,
                    });
                    const response = await fetch(`/account/events?${params.toString()}`, {
                        method: "GET",
                        headers: this.headers
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
                },
                async save() {
                    try {
                        this.loading = true;
                        const response = await fetch('/account/save', {
                            method: "POST",
                            headers: this.headers,
                            body: JSON.stringify(this.form)
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422) {
                                this.errors = data.errors;
                            } else {
                                console.log("Ошибка сервера:", data.message || "Неизвестная ошибка");
                            }
                            return;
                        }

                        this.alertSuccess = true;
                        this.profile = data.profile;
                        this.loading = false;
                        this.errors = {};
                        setTimeout(() => {
                            this.alertSuccess = false;
                            location.reload()
                        }, 4000);

                    } catch (error) {
                        console.log("Ошибка отправки данных:", error);
                    }
                },
                async refresh() {
                    try {
                        this.loading = true
                        const response = await fetch('account', {
                            method: "GET",
                            headers: this.headers
                        })

                        const data = await response.json();

                        if (response.ok) {
                            this.profile.bill = data.bill;
                        }

                        this.loading = false;
                    }
                    catch (e) {
                        console.log(e)
                    }
                }
            }
        }
    </script>
@endsection

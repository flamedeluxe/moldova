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
                            <template x-for="item in profile.socials" :key="item">
                                <div>
                                    <template x-if="item.includes('vk.com')">
                                        <a :href="item">
                                            <img src="img/vk.svg" alt="">
                                            <span>Вконтакте</span>
                                        </a>
                                    </template>

                                    <template x-if="item.includes('t.me')">
                                        <a :href="item">
                                            <img src="img/te.svg" alt="">
                                            <span>Телеграм</span>
                                        </a>
                                    </template>

                                    <template x-if="item.includes('ok.ru')">
                                        <a :href="item">
                                            <img src="img/ok.svg" alt="">
                                            <span>Одноклассники</span>
                                        </a>
                                    </template>
                                </div>
                            </template>
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
                    <div class="keen-slider__slide">
                        <a href="" class="item">
                            <div class="item__img">
                                <img src="img/news1.png" alt="">
                                <div class="item__img-badge">
                                    Новости
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    27 января
                                </div>
                                <div class="item__info-title">
                                    Концерт «Кто помнит, тот не знает поражения»
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="keen-slider__slide">
                        <a href="" class="item">
                            <div class="item__img">
                                <img src="img/news1.png" alt="">
                                <div class="item__img-badge">
                                    Новости
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    27 января
                                </div>
                                <div class="item__info-title">
                                    Концерт «Кто помнит, тот не знает поражения»
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="keen-slider__slide">
                        <a href="" class="item">
                            <div class="item__img">
                                <img src="img/news1.png" alt="">
                                <div class="item__img-badge">
                                    Новости
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    27 января
                                </div>
                                <div class="item__info-title">
                                    Концерт «Кто помнит, тот не знает поражения»
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="keen-slider__slide">
                        <a href="" class="item">
                            <div class="item__img">
                                <img src="img/news1.png" alt="">
                                <div class="item__img-badge">
                                    Новости
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    27 января
                                </div>
                                <div class="item__info-title">
                                    Концерт «Кто помнит, тот не знает поражения»
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="keen-slider__slide">
                        <a href="" class="item">
                            <div class="item__img">
                                <img src="img/news1.png" alt="">
                                <div class="item__img-badge">
                                    Новости
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    27 января
                                </div>
                                <div class="item__info-title">
                                    Концерт «Кто помнит, тот не знает поражения»
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="keen-slider__slide">
                        <a href="" class="item">
                            <div class="item__img">
                                <img src="img/news1.png" alt="">
                                <div class="item__img-badge">
                                    Новости
                                </div>
                            </div>
                            <div class="item__info">
                                <div class="item__info-date">
                                    27 января
                                </div>
                                <div class="item__info-title">
                                    Концерт «Кто помнит, тот не знает поражения»
                                </div>
                            </div>
                        </a>
                    </div>
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
                profile: @json($profile),
                loading: false,
                cities: @json($cities),
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

                init() {
                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    this.form = @json($profile);
                    if (!Array.isArray(this.form.socials) || this.form.socials.length === 0) {
                        this.form.socials = [''];
                    }
                },
                addSocial() {
                    this.form.socials.unshift('');
                },
                removeSocial(index) {
                    if (this.form.socials.length > 1) {
                        this.form.socials.splice(index, 1);
                    }
                },
                async save() {
                    try {
                        this.loading = true;
                        const response = await fetch('/account', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-Requested-With": "XMLHttpRequest",
                                "X-CSRF-TOKEN": this.token
                            },
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
                        closeModals();
                        setTimeout(() => {
                            this.alertSuccess = false
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
                            headers: {
                                "Content-Type": "application/json",
                                'X-Requested-With': 'XMLHttpRequest',
                                "X-CSRF-TOKEN": this.token
                            }
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

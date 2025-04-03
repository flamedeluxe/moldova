@extends('layouts.base')

@section('content')
    <div class="p-account">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="p-account__title">
                        {{ $profile->name }}
                    </div>
                    <div class="p-account__info">
                        <div class="item">
                            <div class="item__title">
                                Регион
                            </div>
                            <div class="item__text">
                                {{ $profile->region ?? '-' }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__title">
                                E-mail
                            </div>
                            <div class="item__text">
                                {{ $profile->email ?? '-' }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__title">
                                Номер телефона
                            </div>
                            <div class="item__text">
                                @if($profile->phone)
                                    {{ $profile->phone }}
                                @else
                                    <a href="" data-modal="#modal_profile">указать</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-account__social">
                        @if($profile->vk)
                            <a href="{{ $profile->vk }}">
                                <img src="img/vk.svg" alt="">
                                <span>Вконтакте</span>
                            </a>
                        @endif

                        @if($profile->te)
                            <a href="{{ $profile->te }}">
                                <img src="img/te.svg" alt="">
                                <span>Телеграм</span>
                            </a>
                        @endif

                        @if($profile->ok)
                            <a href="{{ $profile->ok }}">
                                <img src="img/ok.svg" alt="">
                                <span>Одноклассники</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    @if($profile->bill < 350)
                        <div class="p-account__bar">
                            <div class="p-account__bar-line"></div>
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
                    @else
                        <div class="p-account__edit">
                            <a href="" data-modal="#modal_profile">Редактировать</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="p-card" x-data="card()">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="p-card__info">
                        <img class="p-card__info-img" src="img/card2.png" alt="">
                        <div class="p-card__info-caption">
                            @if($profile->card)
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
                            @else
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
                           @endif
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
    <script>
        function card() {
            return {
                profile: @json($profile),
                loading: false,
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
@endsection

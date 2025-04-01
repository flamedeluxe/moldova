@extends('layouts.base')

@section('content')
    <div class="p-account">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8">
                    <div class="p-account__title">
                        Валентин Войцеховский
                    </div>
                    <div class="p-account__info">
                        <div class="item">
                            <div class="item__title">
                                Регион
                            </div>
                            <div class="item__text">
                                {{ Auth::user()->cities ?? '' }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__title">
                                E-mail
                            </div>
                            <div class="item__text">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__title">
                                Номер телефона
                            </div>
                            <div class="item__text">
                                @if(Auth::user()->phone)
                                    {{ Auth::user()->phone }}
                                @else
                                    <a href="" data-modal="#profile">указать</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-account__social">
                        @if(Auth::user()->vk)
                            <a href="{{ Auth::user()->vk }}">
                                <img src="img/vk.svg" alt="">
                                <span>Вконтакте</span>
                            </a>
                        @endif

                        @if(Auth::user()->te)
                            <a href="{{ Auth::user()->te }}">
                                <img src="img/te.svg" alt="">
                                <span>Телеграм</span>
                            </a>
                        @endif

                        @if(Auth::user()->ok)
                            <a href="{{ Auth::user()->ok }}">
                                <img src="img/ok.svg" alt="">
                                <span>Одноклассники</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="p-account__bar">
                        <div class="p-account__bar-line"></div>
                    </div>
                    <div class="p-account__text">
                        Чтобы начать полноценно пользоваться сервисом, <strong>заполните профиль и получите
                            350 баллов в подарок</strong>
                    </div>
                    <div class="p-account__btn">
                        <button class="btn btn--default" data-modal="#profile">
                            Заполнить профиль
                        </button>
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
@endsection

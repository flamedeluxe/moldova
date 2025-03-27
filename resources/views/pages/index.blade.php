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

    <div class="events">
        <div class="container">
            <div class="row gx-4">
                <div class="col-12 col-sm-4">
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
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__caption">
                            <div class="item__caption-title">
                                Сегодня Карта гражданина Молдовы в РФ перешагнула рубеж в пять тысяч участников
                            </div>
                            <div class="item__caption-date">
                                27 января
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
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
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
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
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
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
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__caption">
                            <div class="item__caption-title">
                                Открытки из России уже отправились в Молдову! 🇲🇩
                            </div>
                            <div class="item__caption-date">
                                27 января
                            </div>
                        </div>
                    </a>
                </div>
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
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm1.jpg">
                        <img src="img/p1.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm2.jpg">
                        <img src="img/p2.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm3.jpg">
                        <img src="img/p3.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm1.jpg">
                        <img src="img/p1.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm2.jpg">
                        <img src="img/p2.png" alt="">
                    </picture>
                </div>
                <div class="keen-slider__slide slide">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/pm3.jpg">
                        <img src="img/p3.png" alt="">
                    </picture>
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

    <div class="events bg--gray">
        <div class="container">
            <div class="events__top">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="events__top-title">
                            <span>Афиша</span>
                            <a href="">Москва</a>
                        </div>
                        <div class="events__top-more">
                            <img src="img/loc.svg" alt="">
                            <span>Найти свой город</span>
                        </div>
                        <div class="events__tags">
                            <div class="tag active">
                                <span>Все</span>
                            </div>
                            <div class="tag">
                                <span>Культура</span>
                            </div>
                            <div class="tag">
                                <span>Спорт</span>
                            </div>
                            <div class="tag">
                                <span>Образование</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="events__dates">
                            <div class="date">
                                <div class="day">
                                    27
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                            <div class="date">
                                <div class="day">
                                    30
                                </div>
                                <div class="month">
                                    Янв
                                </div>
                            </div>
                        </div>
                        <div class="events__select">
                            <div>
                                <input type="text" name="date" placeholder="Выбрать даты" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                27 января
                            </div>
                            <div class="item__info-title">
                                Концерт «Кто помнит, тот не знает поражения»
                            </div>
                            <div class="item__info-text">
                                ул. Волхонка, д. 15, Зал Церковных Соборов Храма Христа Спасителя.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                27 января
                            </div>
                            <div class="item__info-title">
                                Концерт «Кто помнит, тот не знает поражения»
                            </div>
                            <div class="item__info-text">
                                ул. Волхонка, д. 15, Зал Церковных Соборов Храма Христа Спасителя.
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-12 col-sm-4">
                    <a href="" class="item">
                        <div class="item__img">
                            <img src="img/news1.png" alt="">
                        </div>
                        <div class="item__info">
                            <div class="item__info-date">
                                27 января
                            </div>
                            <div class="item__info-title">
                                Концерт «Кто помнит, тот не знает поражения»
                            </div>
                            <div class="item__info-text">
                                ул. Волхонка, д. 15, Зал Церковных Соборов Храма Христа Спасителя.
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="events__more">
                <button class="btn btn--default">
                    Следующие события
                </button>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.base')

@section('content')
    <div class="events">
        <div class="container">
            <div class="p-projects__top">
                <div class="p-projects__top-title">Новости</div>
                <div class="events__select">
                    <div>
                        <input type="text" name="date" placeholder="Выбрать даты" required>
                    </div>
                </div>
            </div>

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

    <div class="events bg--gray">
        <div class="container">
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

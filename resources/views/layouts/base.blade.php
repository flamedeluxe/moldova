<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $resource->title ?? '' }}</title>
    <meta name="description" content="{{ $resource->description ?? '' }}">
    <link rel="icon" href="img/favicon.ico" type="image/x-icon">

    <base href="/">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/keen-slider@latest/keen-slider.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap-reboot.rtl.min.css">
    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <script src="https://api-maps.yandex.ru/2.1/?apikey=ВАШ_API_КЛЮЧ&lang=ru_RU" type="text/javascript"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <link rel="stylesheet" href="css/styles.css">

    @php

    $routeName = request()->route() ? request()->route()->getName() : '';

    @endphp
</head>
<body class="@if(in_array($routeName, ['login', 'register'])) justify-content-sm-center @endif">

<div class="modal__overlay"></div>

<div class="m-search">
    <div class="m-search__input">
        <form action="{{ route('search') }}" method="get">
            <input type="text" name="query" placeholder="Поиск по сайту…">
        </form>
    </div>
    <div class="m-search__close">
        <img src="img/close3.svg" alt="">
        <span>Закрыть поиск</span>
    </div>
</div>
<div class="m-header">
    <div class="m-header__logo">
        <a href="/">
            <img src="img/logo.svg" alt="logo">
        </a>
    </div>
    <div class="m-header__controls">
        <div class="m-header__controls-search">
            <svg class="icon"><use xlink:href="img/sprite.svg#search"></use></svg>
        </div>
        <div class="m-header__controls-burger">
            <svg class="icon"><use xlink:href="img/sprite.svg#burger"></use></svg>
            <svg class="icon" style="display: none;"><use xlink:href="img/sprite.svg#close"></use></svg>
        </div>
    </div>
</div>
<div class="m-header__nav">
    <div class="m-header__nav-menu">
        <ul>
            <li><a href="{{ route('about') }}">О нас</a></li>
            <li><a href="{{ route('projects.index') }}">Наши проекты</a></li>
            <li><a href="{{ route('publications.index') }}">Новости</a></li>
            <li>
                <a href="#">Мы в регионах</a>
            </li>
            <li><a href="{{ route('faq') }}">Вопросы и ответы</a></li>
        </ul>

        <a href="{{ route('account.index') }}" class="btn btn--transperant">
            <img src="img/acc.svg" alt="">
            <span>Личный кабинет</span>
        </a>
    </div>
    <div class="m-header__nav-footer">
        <div class="m-header__nav-footer_email">
            <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
        </div>
        <div class="m-header__nav-footer_social">
            <ul>
                <li><a href="{{ config('site.vk') }}"><img src="img/vk.svg" alt=""></a></li>
                <li><a href="{{ config('site.te') }}"><img src="img/te.svg" alt=""></a></li>
                <li><a href="{{ config('site.ok') }}"><img src="img/ok.svg" alt=""></a></li>
            </ul>
        </div>
        <div class="m-header__nav-footer_text">
            <a href="">Политика конфиденциальности
                в отношении персональных данных</a>
        </div>
    </div>
</div>

<div class="header @if(in_array($routeName, ['login', 'register'])) d-none @endif">
    <div class="container">
        <div class="row align-items-center">
            <div class="col header__logo">
                <a href="/">
                    <img src="img/logo.svg" alt="logo">
                </a>
            </div>
            <div class="col header__menu">
                <div class="">
                    <ul>
                        <li class="{{ $routeName == 'about' ? 'active' : '' }}">
                            <a href="{{ route('about') }}">О нас</a>
                        </li>
                        <li class="{{ $routeName == 'projects.index' ? 'active' : '' }}">
                            <a href="{{ route('projects.index') }}">Наши проекты</a>
                        </li>
                        <li class="{{ $routeName == 'publications.index' ? 'active' : '' }}">
                            <a href="{{ route('publications.index') }}">Новости</a>
                        </li>
                        <li>
                            <a href="#">Мы в регионах</a>
                            <div class="dropdown">
                                <div class="dropdown__cities">
                                    <ul>
                                        <li><a href="region/moskva">Москва</a></li>
                                        <li><a href="region/sankt-peterburg">Санкт-Петербург</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown__list">
                                    <ul>
                                        @foreach($cities as $city)
                                        <li><a href="{{ route('region', $city->slug) }}">{{ $city->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li><a href="{{ route('faq') }}">Вопросы и ответы</a></li>
                    </ul>
                </div>
                <form action="{{ route('search') }}" method="get" class="header__search">
                    <input type="text" name="query" placeholder="Поиск по сайту…">
                    <img src="img/close.svg" alt="">
                </form>
            </div>
            <div class="col header__controls">
                <div class="header__controls-search">
                    <button>
                        <img src="img/search.svg" alt="">
                    </button>
                </div>
                <div class="header__controls-acc">
                    <a href="{{ route('account.index') }}" class="btn btn--transperant">
                        <img src="img/acc.svg" alt="">
                        <span>Личный кабинет</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@yield('content')

@if(!in_array($routeName, ['login', 'register']))

<div class="map bg--gray">
    <div class="container">
        <div class="wrap">
            <div class="row gx-0">
                <div class="col-12 col-sm-6">
                    <div class="map__title">
                        <strong>Культурно-образовательный центр Молдовы</strong> в регионах
                    </div>
                    <div class="map__cities">
                        <div class="map__cities-main">
                            <ul>
                                <li><a href="region/moskva">Москва</a></li>
                                <li><a href="region/sankt-peterburg">Санкт-Петербург</a></li>
                            </ul>
                        </div>
                        <div class="map__cities-list">
                            <ul>
                                @foreach($cities as $city)
                                    <li><a href="{{ route('region', $city->slug) }}">{{ $city->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="faq bg--gray">
    <div class="title">
        <span>Частые вопросы <br>и ответы</span>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8">
                <div class="faq__list">
                    <div class="item accordion-item">
                        <div class="item__title accordion-header">
                            Что такое карта гражданина Молдовы в России и что она даёт?
                        </div>
                        <div class="item__content accordion-content">
                            <p>
                                Карта гражданина Молдовы в России — это документ, который позволяет гражданам Молдовы, проживающим в России, получать ряд преференций и льгот. Основная цель карты — помочь молдавским гражданам в России в решении различных вопросов, связанных с их правом на жительство и трудоустройство.
                            </p>
                        </div>
                    </div>
                    <div class="item accordion-item">
                        <div class="item__title accordion-header">
                            Что такое карта гражданина Молдовы в России и что она даёт?
                        </div>
                        <div class="item__content accordion-content">
                            <p>
                                Карта гражданина Молдовы в России — это документ, который позволяет гражданам Молдовы, проживающим в России, получать ряд преференций и льгот. Основная цель карты — помочь молдавским гражданам в России в решении различных вопросов, связанных с их правом на жительство и трудоустройство.
                            </p>
                        </div>
                    </div>
                    <div class="item accordion-item">
                        <div class="item__title accordion-header">
                            Что такое карта гражданина Молдовы в России и что она даёт?
                        </div>
                        <div class="item__content accordion-content">
                            <p>
                                Карта гражданина Молдовы в России — это документ, который позволяет гражданам Молдовы, проживающим в России, получать ряд преференций и льгот. Основная цель карты — помочь молдавским гражданам в России в решении различных вопросов, связанных с их правом на жительство и трудоустройство.
                            </p>
                        </div>
                    </div>
                    <div class="item accordion-item">
                        <div class="item__title accordion-header">
                            Могут ли воспользоваться услугами мобильной связи, подпиской и страхованием жизни супруг/супруга, если он/она не гражданин/гражданка молдовы? Если да, то сколько это стоит?
                        </div>
                        <div class="item__content accordion-content">
                            <p>
                                Карта гражданина Молдовы в России — это документ, который позволяет гражданам Молдовы, проживающим в России, получать ряд преференций и льгот. Основная цель карты — помочь молдавским гражданам в России в решении различных вопросов, связанных с их правом на жительство и трудоустройство.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="faq__more">
                    <a href="{{ route('faq') }}">
                        <span>Все вопросы и ответы</span>
                        <img src="img/more.svg" alt="Все вопросы и ответы">
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                <div class="faq__form">
                    <div class="faq__form-title">
                        <strong>Помощь</strong> юриста
                    </div>
                    <div class="faq__form-text">
                        Не нашли ответ? Получите персональную консультацию от нашего юриста!
                    </div>
                    <div class="form-group">
                        <input type="text" name="name" placeholder="Имя">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="phone" placeholder="Телефон">
                    </div>
                    <div class="form-group">
                        <textarea name="text" rows="8" placeholder="Ваш вопрос"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="form-checkbox d-flex">
                            <input type="hidden" name="agree" value="">
                            <label class="checkbox">
                                <input type="checkbox" name="agree" value="1">
                                <span></span>
                            </label>
                            <span>
                                    Соглашаюсь с политикой <a href="" target="_blank">конфиденциальности в отношении персональных дынных</a>
                                </span>
                        </div>
                        <span class="error" data-error="agree"></span>
                    </div>

                    <div class="form-group">
                        <button class="btn btn--default">
                            <span>Отправить вопрос</span>
                            <img src="img/more-inverted.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="footer__logo">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/bw-logo-v.svg">
                        <img src="img/logo-w.svg" alt="">
                    </picture>
                </div>
                <div class="footer__text">
                    {{ config('site.address') }}
                </div>
                <div class="footer__link">
                    <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                </div>
            </div>
            <div class="col-12 col-sm-8">
                <div class="row">
                    <div class="col-12 col-sm-9">
                        <form action="{{ route('search') }}" class="footer__search">
                            <input type="text" name="query" value="{{ request('query') }}" placeholder="Поиск по сайту…">
                        </form>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="footer__acc">
                            <a href="{{ route('account.index') }}">
                                <img src="img/acc.svg" alt="">
                                <span>Личный кабинет</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer__nav">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <div class="footer__nav-ul">
                                <ul>
                                    <li><a href="{{ route('about') }}">О нас</a></li>
                                    <li><a href="{{ route('publications.index') }}">Новости</a></li>
                                    <li><a href="">Мы в регионах</a></li>
                                    <li><a href="{{ route('faq') }}">Вопросы и ответы</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-9">
                            <div class="footer__nav-title">
                                Наши проекты
                            </div>
                            <div class="footer__nav-list">
                                <ul>
                                    @foreach($projects as $project)
                                    <li><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="row">
                <div class="col-12 col-sm-4 order-3 order-sm-1">
                    <div class="footer__copy">
                        © АНО «Культурно-образовательный <br>
                        центр Молдовы», {{ date('Y') }}
                    </div>
                </div>
                <div class="col-12 col-sm-5 order-1 order-sm-2">
                    <div class="footer__social">
                        <a href="{{ config('site.vk') }}">
                            <img src="img/vk.svg" alt="Вконтакте">
                            <span>Вконтакте</span>
                        </a>
                        <a href="{{ config('site.te') }}">
                            <img src="img/te.svg" alt="Телеграм">
                            <span>Телеграм</span>
                        </a>
                        <a href="{{ config('site.ok') }}">
                            <img src="img/ok.svg" alt="Одноклассники">
                            <span>Одноклассники</span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-3 order-2 order-sm-3">
                    <div class="footer__policy">
                        <a href="">Политика конфиденциальности в отношении персональных данных</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/air-datepicker@3.5.3/air-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/keen-slider@latest/keen-slider.js"></script>
<script>
    ymaps.ready(function () {
        var myMap = new ymaps.Map('map', {
            center: [55.76, 37.64], // Москва
            zoom: 10,
            controls: [],
            behaviors: ['drag', 'multiTouch']
        });

        const cities = @json($regions);

        cities.forEach(city => {
            if (city.coors) {
                var coordinates = city.coors.split(',').map(Number);
                var socialLinks = city.social ? city.social.map(s => `<a href="${s.link}"><img src="img/${s.service}.svg" alt=""></a>`).join('') : '';
                var socialBlock = socialLinks ? `<div class="map-balloon__top-social">${socialLinks}</div>` : '';

                var placemark = new ymaps.Placemark(coordinates, {
                    balloonContent: `
                    <div class="map-balloon">
                        <div class="map-balloon__top">
                            <div class="map-balloon__top-title">
                                <h3>${city.title}</h3>
                            </div>
                            ${socialBlock}
                        </div>
                        <div class="map-balloon__text">
                            <p>${city.phone || ''}</p>
                            <p>${city.email || ''}</p>
                        </div>
                        <div class="map-balloon__bottom">
                            <a href="regions/${city.slug}">
                                <span>Подробнее</span>
                                <img src="img/more.svg" alt="">
                            </a>
                        </div>
                    </div>
                `
                }, {
                    iconLayout: 'default#image',
                    iconImageHref: 'img/marker.svg',
                    iconImageSize: [32, 32],
                    iconImageOffset: [-16, -32]
                });

                myMap.geoObjects.add(placemark);
            }

            myMap.setBounds(myMap.geoObjects.getBounds());
        });
    });
</script>

@endif

<script src="js/scripts.js"></script>

@if(in_array($routeName, ['index', 'publications.index', 'region', '']))
<script>
    function news() {
        return {
            items: @json($news),
            loading: false,
            total: @json($news_total),
            date: '',
            page: 1,
            error: '',
            filter() {
                this.date = document.querySelector('[x-model="date"]').value;
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
                    type: 'news',
                    page: this.page,
                    date: this.date,
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

                if(response.ok) {
                    const r = await response.json();
                    this.items = r.data;
                    this.total = r.total;
                }
            }
        }
    }
    function events() {
        return {
            items: @json($events),
            cities: @json($cities),
            categories: @json($categories),
            loading: false,
            total: @json($events_total),
            page: 1,
            city: '{{ session()->get('city') ?? 'Москва' }}',
            date: '',
            category: '',
            error: '',
            init() {
                this.category = 'Все';
            },
            filter() {
                this.category = ''; // Очистка категории при фильтрации
                this.date = document.querySelector('[x-model="date"]').value;
                this.get(); // Перезагрузка данных
            },
            nextPage() {
                this.page++; // Переход на следующую страницу
                this.get(); // Получение данных для следующей страницы
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
                } else {
                    this.error = 'Ошибка загрузки данных';
                }
            }
        }
    }
</script>
@endif
</body>
</html>

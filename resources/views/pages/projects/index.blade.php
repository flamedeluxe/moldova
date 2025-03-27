@extends('layouts.base')

@section('content')
    <div class="p-projects">
        <div class="container">
            <div class="p-projects__top">
                <div class="p-projects__top-title">Наши проекты</div>
                <div class="events__select">
                    <div>
                        <input type="text" name="date" placeholder="Выбрать даты" required>
                    </div>
                </div>
            </div>

            <a href="" class="d-block mb-4">
                <picture>
                    <source media="(max-width: 768px)" srcset="img/pm1.jpg">
                    <img src="img/ppp1.jpg" alt="">
                </picture>
            </a>
            <a href="" class="d-block mb-4">
                <picture>
                    <source media="(max-width: 768px)" srcset="img/pm2.jpg">
                    <img src="img/ppp2.jpg" alt="">
                </picture>
            </a>
            <a href="" class="d-block mb-4">
                <picture>
                    <source media="(max-width: 768px)" srcset="img/pm3.jpg">
                    <img src="img/ppp3.jpg" alt="">
                </picture>
            </a>

            <div class="p-projects__bottom">
                <div class="events__select">
                    <div>
                        <img src="img/calendar.svg" alt="">
                        <span>Календарь мероприятий</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

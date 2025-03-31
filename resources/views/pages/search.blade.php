@extends('layouts.base')

@section('content')
    <div class="p-search">
        <div class="container">
            <form action="">
                <input type="text" placeholder="Поиск по сайту…">
            </form>

            <div class="row">
                <div class="col-12 col-sm-9">
                    <div class="p-search__results">
                        <div class="item">
                            <div class="item__title">
                                <a href="">
                                    <span>Карта гражданина Молдовы в России</span>
                                </a>
                            </div>
                            <div class="item__text">
                                Наш Центр — сообщество земляков, <i>которые</i> любят Молдову. Мы — автономная некоммерческая организация «Культурно-образовательный центр Молдовы». Главная цель нашего Центра…
                            </div>
                            <div class="item__link">
                                <a href="moldovacenter.ru/about">moldovacenter.ru/about</a>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item__title">
                                <a href="">
                                    <span>Карта гражданина Молдовы в России</span>
                                </a>
                            </div>
                            <div class="item__text">
                                Наш Центр — сообщество земляков, <i>которые</i> любят Молдову. Мы — автономная некоммерческая организация «Культурно-образовательный центр Молдовы». Главная цель нашего Центра…
                            </div>
                            <div class="item__link">
                                <a href="moldovacenter.ru/about">moldovacenter.ru/about</a>
                            </div>
                        </div>
                    </div>

                    <div class="pagination">
                        <a href="#" class="disabled" aria-disabled="true" aria-label="« Previous">
                            <img src="img/next2.svg" alt="">
                        </a>

                        <a href="#" class="active" aria-current="page">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>

                        <span>...</span>

                        <a href="#">8</a>

                        <a href="#" rel="next" aria-label="Next »">
                            <img src="img/next2.svg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-3 d-none d-sm-block">
                    <div class="p-search__aside">
                        <a href="">
                            <img src="img/card1.png" alt="">
                        </a>
                        <a href="">
                            <img src="img/card1.png" alt="">
                        </a>
                        <a href="">
                            <img src="img/card1.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

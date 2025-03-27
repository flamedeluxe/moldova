@extends('layouts.base')

@section('content')
    <div class="login">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="login__form">
                        <form action="">
                            <div class="login__form-title">
                                <strong>Регистрация</strong> <br>
                                по номеру телефона
                            </div>
                            <div class="form-group">
                                <input type="tel" placeholder="Номер телефона" class="has-error">
                                <div class="error">
                                    Этот номер телефона уже зарегистрирован. Если это ваш номер, попробуйте <a href="">восстановить пароль</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Фамилия Имя Отчество">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Пароль">
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
                                <button class="btn btn--default" style="width: 100%;">
                                    Зарегистрироваться
                                </button>
                            </div>
                            <div class="login__form-text">
                                <strong>или войдите в личный кабинет</strong>, используя <br>
                                номер телефона
                            </div>
                            <div class="form-group">
                                <button class="btn btn--transperant" style="width: 100%;">
                                    Войти в личный кабинет
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-sm-6 d-flex flex-column justify-content-between">
                    <div class="wrapper">
                        <div class="login__logo">
                            <img src="img/logo-big.svg" alt="">
                        </div>
                    </div>
                    <div class="wrapper">
                        <div class="login__nav-footer">
                            <div class="login__nav-footer_email">
                                <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                            </div>
                            <div class="login__nav-footer_social">
                                <ul>
                                    <li>
                                        <a href="{{ config('site.vk') }}">
                                            <img src="img/vk.svg" alt="Вконтакте">
                                            <span>Вконтакте</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ config('site.te') }}">
                                            <img src="img/te.svg" alt="Телеграм">
                                            <span>Телеграм</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ config('site.ok') }}">
                                            <img src="img/ok.svg" alt="Одноклассники">
                                            <span>Одноклассники</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="login__nav-footer_text">
                                <a href="">Политика конфиденциальности
                                    в отношении персональных данных</a>
                            </div>
                            <div class="login__nav-footer_text">
                                © АНО «Культурно-образовательный центр Молдовы», {{ date('Y') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

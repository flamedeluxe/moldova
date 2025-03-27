@extends('layouts.base')

@section('content')
    <div class="login">
        <div class="container">
            <div class="row">
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
                <div class="col-12 col-sm-6">
                    <div class="login__form">
                        <form action="">
                            <div class="login__form-title">
                                <strong>Восстановление пароля</strong> <br>
                                по номеру телефона
                            </div>
                            <div class="form-group">
                                <input type="tel" placeholder="Номер телефона" class="has-error">
                                <div class="error">
                                    Этот номер телефона уже зарегистрирован. Если это ваш номер, попробуйте <a href="">восстановить пароль</a>
                                </div>
                            </div>
                            <div class="login__form-text">
                                Пароль отправлен на ваш номер SMS-сообщением. Поменять его можно в личном кабинете.
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="Пароль из SMS">
                            </div>
                            <div class="form-group">
                                <button class="btn btn--default" style="width: 100%;">
                                    Войти с новым паролем
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="login__error">
                        Что-то пошло не так во время отправки формы. Ведутся технические работы, повторите попытку восстановления пароля позже
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

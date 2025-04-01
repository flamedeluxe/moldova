@extends('layouts.base')

@section('content')
    <div class="login" x-data="login()">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6 d-flex flex-column justify-content-between order-2 order-sm-1">
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
                <div class="col-12 col-sm-6 order-1 order-sm-2">
                    <div class="login__form">
                        <form action="" @submit.prevent="send()">
                            <div class="login__form-title">
                                <strong>Вход в личный кабинет</strong> <br>
                                по номеру телефона
                            </div>
                            <div class="form-group">
                                <input type="tel"
                                       x-model="form.phone"
                                       placeholder="Введите номер телефона"
                                       :class="{ 'has-error': errors.phone }">
                                <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
                            </div>
                            <div class="form-group">
                                <input type="password"
                                       x-model="form.password"
                                       placeholder="Введите пароль"
                                       :class="{ 'has-error': errors.password }">
                                <span class="error" x-text="errors.password ? errors.password[0] : ''"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn--default" style="width: 100%;">
                                    Войти
                                </button>
                            </div>
                            <div class="login__form-text">
                                <strong>или зарегистрируйтесь,</strong> чтобы начать <br>
                                пользоваться личным кабинетом Культурно- <br>
                                образовательного центра Молдовы
                            </div>
                            <div class="form-group">
                                <a href="{{ route('register') }}" class="btn btn--transperant" style="width: 100%;">
                                    Зарегистрироваться
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function login() {
            return {
                form: {
                    phone: '',
                    password: '',
                },
                token: '',
                errors: {},
                init() {
                    this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                },
                async send() {
                    try {
                        const response = await fetch('api/login', {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                'X-Requested-With': 'XMLHttpRequest',
                                "X-CSRF-TOKEN": this.token
                            },
                            body: JSON.stringify(this.form)
                        })

                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422) {
                                this.errors = data.errors;
                            } else {
                                console.log("Ошибка сервера:", data.message || "Неизвестная ошибка");
                            }
                            return;
                        }

                        this.errors = {};
                    }
                    catch (e) {
                        console.log(e)
                    }
                }
            }
        }
    </script>
@endsection

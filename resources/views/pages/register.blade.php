@extends('layouts.base')

@section('content')
    <div class="login" x-data="register()">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="login__form">
                        <form action="" @submit.prevent="send()">
                            <div class="login__form-title">
                                <strong>Регистрация</strong> <br>
                                по номеру телефона
                            </div>
                            <div class="form-group">
                                <input type="tel"
                                       x-model="form.phone"
                                       placeholder="Номер телефона"
                                       :class="{ 'has-error': errors.phone }">
                                <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
                            </div>
                            <div class="form-group">
                                <input type="text"
                                       x-model="form.name"
                                       placeholder="Фамилия Имя Отчество"
                                       :class="{ 'has-error': errors.name }">
                                <span class="error" x-text="errors.name ? errors.name[0] : ''"></span>
                            </div>
                            <div class="form-group">
                                <input type="password"
                                       x-model="form.password"
                                       placeholder="Введите пароль"
                                       :class="{ 'has-error': errors.password }">
                                <span class="error" x-text="errors.password ? errors.password[0] : ''"></span>
                            </div>
                            <div class="form-group">
                                <div class="form-checkbox d-flex">
                                    <label class="checkbox">
                                        <input type="checkbox" x-model="form.agree">
                                        <span></span>
                                    </label>
                                    <span>
                                        Соглашаюсь с политикой <a href="" target="_blank">конфиденциальности в отношении персональных дынных</a>
                                    </span>
                                </div>
                                <span class="error" x-text="errors.agree ? errors.agree[0] : ''"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn--default" style="width: 100%;">
                                    Зарегистрироваться
                                </button>
                            </div>
                            <div class="login__form-text">
                                <strong>или войдите в личный кабинет</strong>, используя <br>
                                номер телефона
                            </div>
                            <div class="form-group">
                                <a href="{{ route('login') }}" class="btn btn--transperant" style="width: 100%;">
                                    Войти в личный кабинет
                                </a>
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

    <script>
        function register() {
            return {
                form: {
                    name: '',
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
                        const response = await fetch('api/register', {
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

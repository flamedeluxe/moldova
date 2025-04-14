@extends('layouts.base')

@section('content')
    <div class="login" x-data="app()">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="login__form">
                        <form action="">
                            <div class="login__form-title">
                                <strong>Регистрация</strong> <br>
                                по номеру телефона
                            </div>
                            <div x-show="step == 1">
                                <div class="form-group">
                                    <input type="text"
                                           x-model="form.email"
                                           placeholder="E-mail"
                                           :class="{ 'has-error': errors.email }">
                                    <span class="error" x-text="errors.email ? errors.email[0] : ''"></span>
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
                                    <input type="tel"
                                           x-model="form.phone"
                                           placeholder="Номер телефона"
                                           :class="{ 'has-error': errors.phone }">
                                    <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
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
                                    <button type="button" @click.prevent="register()" class="btn btn--default" style="width: 100%;">
                                        <span x-text="!loading ? 'Получить код' : 'Подождите...'"></span>
                                    </button>
                                </div>
                            </div>
                            <div x-show="step == 2">
                                <div class="form-group">
                                    <input type="text"
                                           x-model="form.code"
                                           placeholder="Введите код"
                                           :class="{ 'has-error': errors.code }">
                                    <span class="error" x-text="errors.code ? errors.code[0] : ''"></span>

                                    <div class="mt-1" x-show="timeout > 0">
                                        Новый код через <span x-text="timeout"></span> сек
                                    </div>
                                    <div class="mt-1" x-show="timeout === 0" @click="getCode()">
                                        Выслать новый код
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="button" @click.prevent="confirm_register()" class="btn btn--default" style="width: 100%;">
                                        <span x-text="!loading ? 'Зарегистрироваться' : 'Подождите...'"></span>
                                    </button>
                                </div>
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
                                <a href="policy">Политика конфиденциальности
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
        function app() {
            return {
                form: {
                    name: '',
                    phone: '',
                    email: '',
                    password: '',
                    code: '',
                },
                step: 1,
                token: '',
                timeout: 0,
                errors: {},
                headers: {},
                interval: null,
                loading: false,

                init() {
                    this.token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    this.timeout = parseInt(localStorage.getItem('code_timeout')) || 0;

                    this.headers = {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
                    };
                },

                async request(url) {
                    try {
                        this.loading = true;
                        const response = await fetch(url, {
                            method: "POST",
                            headers: this.headers,
                            body: JSON.stringify(this.form)
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 419) location.reload();

                            if (response.status === 422) {
                                this.errors = data.errors || {};
                            } else {
                                console.error("Ошибка сервера:", data.message || "Неизвестная ошибка");
                            }
                            return null;
                        }

                        this.errors = {};
                        return data;
                    } catch (e) {
                        console.error("Ошибка запроса:", e);
                        return null;
                    } finally {
                        this.loading = false;
                    }
                },

                async confirm_register() {
                    const result = await this.request('api/confirm_register')

                    if(result.success) {
                        location.href = '/account';
                    }
                },

                async register() {
                    const result = await this.request('api/register');

                    if (result.success) {
                        this.step = 2;
                        this.startTimer(45);
                    }
                },

                startTimer(seconds) {
                    this.timeout = seconds;
                    localStorage.setItem('code_timeout', this.timeout);

                    clearInterval(this.interval);
                    this.interval = setInterval(() => {
                        this.timeout--;
                        localStorage.setItem('code_timeout', this.timeout);

                        if (this.timeout <= 0) {
                            clearInterval(this.interval);
                        }
                    }, 1000);
                }
            };
        }
    </script>
@endsection

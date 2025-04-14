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
                                       :disabled="step == 2"
                                       :class="{ 'has-error': errors.phone }">
                                <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
                            </div>
                            <div x-show="step == 1">
                                <div class="form-group">
                                    <button type="button" @click.prevent="getCode()" class="btn btn--default" style="width: 100%;">
                                        Получить код
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
                                    <button type="submit" class="btn btn--default" style="width: 100%;">
                                        Войти
                                    </button>
                                </div>
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
                    code: '',
                },
                timeout: 0,
                token: '',
                step: 1,
                errors: {},
                headers: {},
                interval: null,
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
                    }
                },
                async getCode() {
                    const result = await this.request('api/getCode');

                    if(result) {
                        this.step = 2;
                        this.startTimer(45);
                    }
                },
                async send() {
                    const result = await this.request('api/login');

                    if (result.success) {
                        location.href = '/account';
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

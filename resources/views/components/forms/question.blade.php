<div class="question-button" data-modal="#modal_question">
    <img src="img/question.svg" alt="">
    <span>Задать вопрос</span>
</div>

<div class="modal modal__question" id="modal_question">
    <div class="wrap">
        <div class="modal__close">
            <img src="img/close.svg" alt="">
        </div>
        <div class="modal__content">
            <div class="modal__question-form" x-data="question()">
                <div x-show="success" class="alert alert--success">
                    Ваше обращение успешно отправлено
                </div>
                <form @submit.prevent="send()" class="faq__form" id="faq" x-show="!success">
                    <div class="faq__form-title">
                        Задать вопрос
                    </div>
                    <div class="faq__form-text">
                        Заполните форму с вашим вопросом. Отвечаем быстро.
                    </div>

                    <div class="form-group">
                        <input type="text" x-model="form.name" placeholder="Имя" :class="{ 'has-error': errors.name }">
                        <span class="error" x-text="errors.name ? errors.name[0] : ''"></span>
                    </div>

                    <div class="form-group">
                        <input type="text" x-model="form.contacts" placeholder="Номер телефона или Email" :class="{ 'has-error': errors.contacts }">
                        <span class="error" x-text="errors.contacts ? errors.contacts[0] : ''"></span>
                    </div>

                    <div class="form-group">
                        <textarea x-model="form.text" rows="8" placeholder="Ваш вопрос" :class="{ 'has-error': errors.text }"></textarea>
                        <span class="error" x-text="errors.text ? errors.text[0] : ''"></span>
                    </div>

                    <div class="form-group">
                        <div class="form-checkbox d-flex" @click="form.agree = form.agree == false">
                            <label class="checkbox">
                                <input type="checkbox" x-model="form.agree">
                                <span></span>
                            </label>
                            <span>
                                Соглашаюсь с политикой <a href="policy" target="_blank">конфиденциальности в отношении персональных данных</a>
                            </span>
                        </div>
                        <span class="error" x-text="errors.agree ? errors.agree[0] : ''"></span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn--default">
                            <span>Отправить вопрос</span>
                            <img src="img/more-inverted.svg" alt="">
                        </button>
                    </div>
                </form>

                <div class="login__nav-footer">
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
                    <div class="login__nav-footer_email">
                        <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function question() {
        return {
            form: {
                name: '',
                contacts: '',
                text: '',
                agree: false
            },
            success: false,
            token: '',
            errors: {},
            init() {
                this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            },
            async send() {
                try {
                    const response = await fetch('api/question', {
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
                    this.success = true;
                }
                catch (e) {
                    console.log(e)
                }
            }
        }
    }
</script>

<div x-data="feedbackModal()" id="faq">
    <div x-show="success" class="alert alert--success">
        Ваше обращение успешно отправлено
    </div>

    <form @submit.prevent="send()" class="faq__form mt-0" x-show="step == 2">
        <div class="faq__form-title mb-4">
            <strong>Укажите код из смс для подтверждения номера</strong>
        </div>

        <div class="form-group">
            <input type="text" x-model="form.code" placeholder="" :class="{ 'has-error': errors.code }">
            <span class="error" x-text="errors.code ? errors.code[0] : ''"></span>
            <div class="helper mt-2">
                Пароль отправлен на ваш номер <span x-text="form.phone"></span> SMS-сообщением.
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn--default">
                <span>Отправить сообщение</span>
            </button>
        </div>
    </form>

    <form @submit.prevent="getCode()" class="faq__form mt-0" x-show="step == 1">
        <div class="faq__form-title mb-4">
            <strong>Обратная связь</strong>
        </div>
 
        <div class="form-group">
            <label for="" class="bold">Фамилия</label>
            <input type="text" x-model="form.surname" placeholder="" @input="cleanErrorsOnInput('surname')" :class="{ 'has-error': errors.surname }">
            <span class="error" x-text="errors.surname ? errors.surname[0] : ''"></span>
        </div>

        <div class="form-group">
            <label for="" class="bold">Имя</label>
            <input type="text" x-model="form.name" placeholder="" @input="cleanErrorsOnInput('name')" :class="{ 'has-error': errors.name }">
            <span class="error" x-text="errors.name ? errors.name[0] : ''"></span>
        </div>

        <div class="form-group">
            <label for="" class="bold">Отчество</label>
            <input type="text" x-model="form.patrynomic" placeholder="" @input="cleanErrorsOnInput('patrynomic')" :class="{ 'has-error': errors.patrynomic }">
            <span class="error" x-text="errors.patrynomic ? errors.patrynomic[0] : ''"></span>
        </div>

        <div class="form-group">
            <label for="" class="bold">Телефон</label>
            <input type="tel" x-model="form.phone" placeholder="" @input="cleanErrorsOnInput('phone')" :class="{ 'has-error': errors.phone }">
            <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
        </div>
        
        <div class="form-group">
            <label for="" class="bold">E-mail</label>
            <input type="email" x-model="form.email" placeholder="Укажите ваш e-mail" @input="cleanErrorsOnInput('email')" :class="{ 'has-error': errors.email }">
            <span class="error" x-text="errors.email ? errors.email[0] : ''"></span>
        </div>

        <div class="form-group">
            <textarea x-model="form.text" rows="4" placeholder="Ваш вопрос" @input="cleanErrorsOnInput('text')" :class="{ 'has-error': errors.text }"></textarea>
            <span class="error" x-text="errors.text ? errors.text[0] : ''"></span>
        </div>

        <div class="form-group">
            <div class="form-checkbox d-flex">
                <label class="checkbox">
                    <input type="checkbox" x-model="form.agree">
                    <span></span>
                </label>
                <span @click="form.agree = form.agree == false">
                    Соглашаюсь с политикой <a href="policy" target="_blank">конфиденциальности в отношении персональных данных</a>
                </span>
            </div>
            <span class="error" x-text="errors.agree ? errors.agree[0] : ''"></span>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn--default">
                <span>Подтвердить номер</span>
            </button>
        </div>
    </form>
</div>
<script>
        function feedbackModal() {
            return {
                form: {
                    surname: '',
                    name: '',
                    patrynomic: '',
                    phone: '',
                    email: '',
                    code: '',
                    text: '',
                    agree: false
                },
                step: 1,
                success: false,
                headers: {},
                token: '',
                timeout: 0,
                errors: {},
                init() {
                    this.token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                    this.timeout = parseInt(localStorage.getItem('code_timeout')) || 0;

                    this.headers = {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": this.token
                    };
                },
                cleanErrorsOnInput(field) {
                    this.errors[field] = '';
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
                async getCode() {
                    const result = await this.request('api/feedback-modal');

                    if(result) {
                        this.step = 2;
                        this.startTimer(45);
                    }
                },
                async send() {
                    const result = await this.request('api/feedback-modal');

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
            }
        }
</script>

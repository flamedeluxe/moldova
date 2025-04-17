<div x-data="feedback()">
    <div x-show="success" class="alert alert--success">
        Ваше обращение успешно отправлено
    </div>
    <form @submit.prevent="send()" class="faq__form" id="faq" x-show="!success">
        <div class="faq__form-title">
            <strong>Помощь</strong> юриста
        </div>
        <div class="faq__form-text">
            Не нашли ответ? Получите персональную консультацию от нашего юриста!
        </div>

        <div class="form-group">
            <input type="text" x-model="form.name" placeholder="Имя" :class="{ 'has-error': errors.name }">
            <span class="error" x-text="errors.name ? errors.name[0] : ''"></span>
        </div>

        <div class="form-group">
            <input type="tel" x-model="form.phone" placeholder="Телефон" :class="{ 'has-error': errors.phone }">
            <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
        </div>

        <div class="form-group">
            <textarea x-model="form.text" rows="8" placeholder="Ваш вопрос" :class="{ 'has-error': errors.text }"></textarea>
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
                <span>Отправить вопрос</span>
                <img src="img/more-inverted.svg" alt="">
            </button>
        </div>
    </form>
</div>
<script>
    function feedback() {
        return {
            form: {
                name: '',
                phone: '',
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
                    const response = await fetch('api/feedback', {
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

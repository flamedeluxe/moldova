<form @submit.prevent="save()" x-data="profile">
    <div class="modal__profile-title">
        Профиль
    </div>
    <div class="alert alert--success" x-show="alertSuccess" x-cloak>
        Данные успешно сохранены
    </div>
    <div class="modal__group">
        <div class="form-group">
            <label for="">Фамилия</label>
            <input type="text" x-model="form.surname" placeholder="" :class="{ 'has-error': errors.surname }">
            <span class="error" x-text="errors.surname ? errors.surname[0] : ''"></span>
        </div>
        <div class="form-group">
            <label for="">Имя</label>
            <input type="text" x-model="form.name" placeholder="" :class="{ 'has-error': errors.name }">
            <span class="error" x-text="errors.name ? errors.name[0] : ''"></span>
        </div>
        <div class="form-group">
            <label for="">Отчество</label>
            <input type="text" x-model="form.patronymic" placeholder="" :class="{ 'has-error': errors.patronymic }">
            <span class="error" x-text="errors.patronymic ? errors.patronymic[0] : ''"></span>
        </div>
        <div class="form-group">
            <label for="">Дата рождения</label>
            <input type="date" x-model="form.birthday" placeholder="" :class="{ 'has-error': errors.birthday }">
            <span class="error" x-text="errors.birthday ? errors.birthday[0] : ''"></span>
        </div>
        <div class="form-group">
            <label for="">Телефон</label>
            <input type="tel" x-model="form.phone" placeholder="" :class="{ 'has-error': errors.phone }">
            <span class="error" x-text="errors.phone ? errors.phone[0] : ''"></span>
        </div>
        <div class="form-group">
            <label for="">E-mail</label>
            <input type="email" x-model="form.email" placeholder="" :class="{ 'has-error': errors.email }">
            <span class="error" x-text="errors.email ? errors.email[0] : ''"></span>
        </div>
    </div>
    <div class="modal__group">
        <div class="modal__group-title">
            Социальные сети
        </div>
        <template x-for="(social, index) in form.socials" :key="index">
            <div class="input-wrap">
                <input type="text" x-model="form.socials[index]" placeholder="Ссылка на профиль">
                <span class="remove" @click="removeSocial(index)" x-show="form.socials.length - 1 !== index">Удалить</span>
                <span class="add" @click="addSocial()" x-show="form.socials.length - 1 === index">Добавить</span>
            </div>
        </template>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn--default">
            Сохранить профиль
        </button>
    </div>
</form>

<script>
    function profile() {
        return {
            form: {
                surname: '',
                name: '',
                patronymic: '',
                birthday: '',
                phone: '',
                email: '',
                socials: ['']
            },
            alertSuccess: false,
            token: '',
            errors: {},

            init() {
                this.token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                this.form = @json($profile);
                if (!Array.isArray(this.form.socials) || this.form.socials.length === 0) {
                    this.form.socials = [''];
                }
            },
            addSocial() {
                this.form.socials.unshift('');
            },
            removeSocial(index) {
                if (this.form.socials.length > 1) {
                    this.form.socials.splice(index, 1);
                }
            },
            async save() {
                try {
                    const response = await fetch('/account', {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": this.token
                        },
                        body: JSON.stringify(this.form)
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        if (response.status === 422) {
                            this.errors = data.errors;
                        } else {
                            console.log("Ошибка сервера:", data.message || "Неизвестная ошибка");
                        }
                        return;
                    }

                    this.alertSuccess = true;
                    setTimeout(() => this.alertSuccess = false, 4000);
                    this.errors = {};
                } catch (error) {
                    console.log("Ошибка отправки данных:", error);
                }
            },
        }
    }
</script>

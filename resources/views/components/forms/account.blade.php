<form @submit.prevent="save()">
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
            <label for="">Регион</label>
            <select x-model="form.region" placeholder="" :class="{ 'has-error': errors.region }">
                <option value="">Выберите</option>
                <template x-for="city in cities" :key="city.id">
                    <option :value="city.title" x-text="city.title"></option>
                </template>
            </select>
            <span class="error" x-text="errors.city ? errors.city[0] : ''"></span>
        </div>
        <div class="form-group">
            <label for="">Дата рождения</label>
            <input type="date" x-model="form.birthday" placeholder="ДД / ММ / ГГГГ" :class="{ 'has-error': errors.birthday }">
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

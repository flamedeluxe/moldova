<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-4">
                <div class="footer__logo">
                    <picture>
                        <source media="(max-width: 768px)" srcset="img/bw-logo-v.svg">
                        <img src="img/logo-w.svg" alt="">
                    </picture>
                </div>
                <div class="footer__text">
                    {{ config('site.address') }}
                </div>
                <div class="footer__link">
                    <a href="mailto:{{ config('site.email') }}">{{ config('site.email') }}</a>
                </div>
            </div>
            <div class="col-12 col-sm-8">
                <div class="row">
                    <div class="col-12 col-sm-9">
                        <form action="{{ route('search') }}" class="footer__search">
                            <input type="text" name="query" value="{{ request('query') }}" placeholder="Поиск по сайту…">
                        </form>
                    </div>
                    <div class="col-12 col-sm-3">
                        <div class="footer__acc">
                            <a href="{{ route('account.index') }}">
                                <img src="img/acc.svg" alt="">
                                <span>Личный кабинет</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer__nav">
                    <div class="row">
                        <div class="col-12 col-sm-3">
                            <div class="footer__nav-ul">
                                <ul>
                                    <li><a href="{{ route('about') }}">О нас</a></li>
                                    <li><a href="{{ route('news.index') }}">Новости</a></li>
                                    <li><a href="">Мы в регионах</a></li>
                                    <li><a href="{{ route('faq.index') }}">Вопросы и ответы</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-sm-9">
                            <div class="footer__nav-title">
                                Наши проекты
                            </div>
                            <div class="footer__nav-list">
                                <ul>
                                    @foreach($projects as $project)
                                        <li><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__bottom">
            <div class="row">
                <div class="col-12 col-sm-4 order-3 order-sm-1">
                    <div class="footer__copy">
                        © АНО «Культурно-образовательный <br>
                        центр Молдовы», {{ date('Y') }}
                    </div>
                </div>
                <div class="col-12 col-sm-5 order-1 order-sm-2">
                    <div class="footer__social">
                        <a href="{{ config('site.vk') }}">
                            <img src="img/vk.svg" alt="Вконтакте">
                            <span>Вконтакте</span>
                        </a>
                        <a href="{{ config('site.te') }}">
                            <img src="img/te.svg" alt="Телеграм">
                            <span>Телеграм</span>
                        </a>
                        <a href="{{ config('site.ok') }}">
                            <img src="img/ok.svg" alt="Одноклассники">
                            <span>Одноклассники</span>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-sm-3 order-2 order-sm-3">
                    <div class="footer__policy">
                        <a href="policy">Политика конфиденциальности в отношении персональных данных</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

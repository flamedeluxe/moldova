<div class="faq bg--gray">
    <div class="title">
        <span>Частые вопросы <br>и ответы</span>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8">
                <div class="faq__list">
                    @foreach($faq as $item)
                        <div class="item accordion-item">
                            <div class="item__title accordion-header">
                                {!! $item->title !!}
                            </div>
                            <div class="item__content accordion-content">
                                {!! $item->content !!}
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="faq__more">
                    <a href="{{ route('faq') }}">
                        <span>Все вопросы и ответы</span>
                        <img src="img/more.svg" alt="Все вопросы и ответы">
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-4" x-data="feedback()">
                @include('components.forms.feedback')
            </div>
        </div>
    </div>
</div>

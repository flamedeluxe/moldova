<div class="faq bg--gray">
    <div class="title">
        <span>Частые вопросы <br>и ответы</span>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8">
                <div class="faq__list">
                    @foreach($faq as $idx => $item)
                        <div class="item">
                            <div class="item__title">
                                <a href="{{ route('faq.show', $item->slug) }}">
                                    {!! $item->title !!}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="faq__more">
                    <a href="{{ route('faq.index') }}">
                        <span>Все вопросы и ответы</span>
                        <img src="img/more.svg" alt="Все вопросы и ответы">
                    </a>
                </div>
            </div>
            <div class="col-12 col-sm-4">
                @include('components.forms.feedback')
            </div>
        </div>
    </div>
</div>

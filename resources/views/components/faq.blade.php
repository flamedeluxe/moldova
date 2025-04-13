<div class="faq bg--gray">
    <div class="title">
        <span>Частые вопросы <br>и ответы</span>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-8">
                <div class="faq__list">
                    @foreach($faq as $idx => $item)
                        <div class="item accordion-item {{ $idx == 0 ? 'active': '' }}">
                            <div class="item__title accordion-header">
                                {!! $item->title !!}
                            </div>
                            <div class="item__content accordion-content" style="{{ $idx == 0 ? 'min-height:30px': '' }}">
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
            <div class="col-12 col-sm-4">
                @include('components.forms.feedback')
            </div>
        </div>
    </div>
</div>

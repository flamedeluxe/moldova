@if ($paginator->hasPages())
    <div class="pagination">
        @if ($paginator->onFirstPage())
            <a href="#" class="disabled" aria-disabled="true" aria-label="« Назад">
                <img src="img/next2.svg" alt="">
            </a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" aria-label="« Назад">
                <img src="img/next2.svg" alt="">
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <a href="#" class="active" aria-current="page">{{ $element }}</a>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="active" aria-current="page">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next »">
                <img src="img/next2.svg" alt="">
            </a>
        @else
            <a href="#" class="disabled" rel="next" aria-label="Next »">
                <img src="img/next2.svg" alt="">
            </a>
        @endif

    </div>
@endif

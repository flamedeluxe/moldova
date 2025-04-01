@extends('layouts.base')

@section('content')
    <div class="p-search">
        <div class="container">
            <form action="{{ route('search') }}" method="get">
                <input type="text" name="query" value="{{ request('query') }}" placeholder="Поиск по сайту…">
            </form>

            @if(count($results) == 0)
                <div class="mt-5">
                    Поиск не дал результатов
                </div>
            @else
            <div class="row">
                <div class="col-12 col-sm-9">
                    <div class="p-search__results">
                        @foreach ($results as $result)
                            <div class="item">
                                <div class="item__title">
                                    <a href="{{ route('publications.show', $result->slug) }}">
                                        <span>{!! highlightSearch($result->title, $search) !!}</span>
                                    </a>
                                </div>
                                <div class="item__text">
                                    {!! highlightSearch($result->content, $search) !!}
                                </div>
                                <div class="item__link">
                                    <a href="{{ route('publications.show', $result->slug) }}">{{ route('publications.show', $result->slug) }}</a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="pagination">
                        {{ $results->appends(['query' => request('query')])->links('pagination.custom') }}
                    </div>
                </div>
                <div class="col-12 col-sm-3 d-none d-sm-block">
                    <div class="p-search__aside">
                        <a href="">
                            <img src="img/card1.png" alt="">
                        </a>
                        <a href="">
                            <img src="img/card1.png" alt="">
                        </a>
                        <a href="">
                            <img src="img/card1.png" alt="">
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

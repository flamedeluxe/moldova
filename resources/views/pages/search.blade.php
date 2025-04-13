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

                <div class="p-search__results">
                    @foreach ($results as $result)
                        <div class="item">
                            <div class="row">
                                <div class="col-12 col-md-8">
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
                                <div class="col-12 col-md-4">
                                    <img src="{{ asset('storage/' . $result->image) }}" alt="">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="pagination">
                    {{ $results->appends(['query' => request('query')])->links('pagination.custom') }}
                </div>

            @endif
        </div>
    </div>
@endsection

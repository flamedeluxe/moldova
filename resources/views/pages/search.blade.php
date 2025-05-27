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
                                        @if($result instanceof App\Models\Publication && $result->slug)
                                            <a href="{{ route('news.show', $result->slug) }}">
                                                <span>{!! highlightSearch($result->title, $search) !!}</span>
                                            </a>
                                        @elseif($result instanceof App\Models\Page && $result->slug)
                                            <a href="{{ route('pages.show', $result->slug) }}">
                                                <span>{!! highlightSearch($result->title, $search) !!}</span>
                                            </a>
                                        @elseif($result instanceof App\Models\Question)
                                            <span>{!! highlightSearch($result->title, $search) !!}</span>
                                        @else
                                            <span>{!! highlightSearch($result->title, $search) !!}</span>
                                        @endif
                                    </div>
                                    <div class="item__text">
                                        {!! highlightSearch($result->content, $search) !!}
                                    </div>
                                    <div class="item__link">
                                        @if($result instanceof App\Models\Publication && $result->slug)
                                            <a href="{{ route('news.show', $result->slug) }}">{{ route('news.show', $result->slug) }}</a>
                                        @elseif($result instanceof App\Models\Page && $result->slug)
                                            <a href="{{ route('pages.show', $result->slug) }}">{{ route('pages.show', $result->slug) }}</a>
                                        @endif
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

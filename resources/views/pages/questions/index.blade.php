@extends('layouts.base')

@section('content')
    <div class="p-questions">
        <div class="container">
            <div class="p-questions__title">
                <strong>Вопросы</strong> и ответы
            </div>
            <div class="p-questions__list">
                <ul>
                    @foreach($resources as $item)
                    <li class="item">
                        <div class="item__title">
                            <a href="{{ route('faq.show', $item->slug) }}">
                                {!! $item->title !!}
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

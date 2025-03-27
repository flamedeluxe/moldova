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
                    <li class="item accordion-item">
                        <div class="item__title accordion-header">
                            {!! $item->title !!}
                        </div>
                        <div class="item__content accordion-content">
                            {!! $item->content !!}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Publication;
use App\Models\Question;

class SearchController extends BaseController
{
    public function index()
    {
        $search = request('query');

        // Разбиваем запрос на отдельные слова
        $words = explode(' ', $search);

        // Ищем в каждой модели
        $results = collect();

        // Поиск в модели Publication
        $publicationResults = Publication::query()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->where('title', 'LIKE', '%' . $word . '%')
                        ->orWhere('content', 'LIKE', '%' . $word . '%');
                }
            })
            ->get();

        $results = $results->merge($publicationResults);

        // Поиск в модели Page
        $pageResults = Page::query()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->where('title', 'LIKE', '%' . $word . '%')
                        ->orWhere('content', 'LIKE', '%' . $word . '%');
                }
            })
            ->get();

        $results = $results->merge($pageResults);

        // Поиск в модели Question
        $questionResults = Question::query()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->where('title', 'LIKE', '%' . $word . '%')
                        ->orWhere('content', 'LIKE', '%' . $word . '%');
                }
            })
            ->get();

        $results = $results->merge($questionResults);

        // Пагинируем результаты (если нужно, добавим кастомную пагинацию, если результат не помещается)
        $paginatedResults = $results->paginate(10);

        return view('pages.search', compact('paginatedResults', 'search'));
    }
}

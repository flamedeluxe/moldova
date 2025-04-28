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

        // Массив для хранения объединенных результатов
        $results = collect();

        // Поиск в модели Publication
        $publicationResults = Publication::query()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->where('title', 'LIKE', '%' . $word . '%')
                        ->orWhere('content', 'LIKE', '%' . $word . '%');
                }
            })
            ->get(); // Получаем все результаты

        $results = $results->merge($publicationResults);

        // Поиск в модели Page (по полю JSON 'blocks')
        $pageResults = Page::query()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(blocks, '$.*')) LIKE ?", ['%' . $word . '%']);
                }
            })
            ->get(); // Получаем все результаты

        $results = $results->merge($pageResults);

        // Поиск в модели Question
        $questionResults = Question::query()
            ->where(function ($query) use ($words) {
                foreach ($words as $word) {
                    $query->where('title', 'LIKE', '%' . $word . '%')
                        ->orWhere('content', 'LIKE', '%' . $word . '%');
                }
            })
            ->get(); // Получаем все результаты

        $results = $results->merge($questionResults);

        // Защита от ошибки count, если результатов нет
        $resultsCount = $results->count();

        // Пагинация с защитой от ошибки
        $paginatedResults = $results->forPage(request('page', 1), 10); // Разделим на страницы по 10 элементов
        $paginatedResults = new \Illuminate\Pagination\LengthAwarePaginator(
            $paginatedResults,
            $resultsCount,
            10,
            request('page', 1),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $resource = (object)[
            'title' => 'Поиск по сайту',
            'description' => ''
        ];

        return view('pages.search', [
            'results' => $paginatedResults,
            'search' => $search,
            'resource' => $resource,
        ]);
    }



}

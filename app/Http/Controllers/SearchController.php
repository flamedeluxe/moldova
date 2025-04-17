<?php

namespace App\Http\Controllers;

use App\Models\Publication;

class SearchController extends BaseController
{
    public function index()
    {
        $search = request('query');

        // Сначала пытаемся найти точное совпадение
        $results = Publication::query()
            ->when($search, function ($query, $search) {
                // Поиск точного совпадения
                $query->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('content', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(['query' => $search]);

        // Если результаты пустые, пытаемся искать по отдельным словам
        if ($results->isEmpty() && $search) {
            $words = explode(' ', $search); // Разбиваем строку на отдельные слова

            $results = Publication::query()
                ->where(function ($query) use ($words) {
                    foreach ($words as $word) {
                        $query->where('title', 'LIKE', '%' . $word . '%')
                            ->orWhere('content', 'LIKE', '%' . $word . '%');
                    }
                })
                ->paginate(10)
                ->appends(['query' => $search]);
        }

        return view('pages.search', compact('results', 'search'));
    }
}

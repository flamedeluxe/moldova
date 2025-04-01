<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\DB;

class SearchController extends BaseController
{
    public function index()
    {
        $search = request('query');
        $results = \App\Models\Publication::query()
            ->when($search, function ($query, $search) {
                $query->whereRaw("MATCH(title, content) AGAINST(? IN BOOLEAN MODE)", [$search . '*']);
            })
            ->paginate(10)
            ->appends(['query' => $search]);

        return view('pages.search', compact('results', 'search'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Support\Facades\DB;

class SearchController extends BaseController
{
    public function index()
    {

        $search = request('query');
        $results = DB::table('publications')
            ->whereRaw("MATCH(title, content) AGAINST(? IN NATURAL LANGUAGE MODE)", [$search])
            ->paginate(10); // 10 записей на страницу

        return view('pages.search', compact('results', 'search'));
    }
}

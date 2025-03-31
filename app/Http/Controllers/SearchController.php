<?php

namespace App\Http\Controllers;

use App\Models\Question;

class SearchController extends BaseController
{
    public function index()
    {
        return view('pages.search');
    }
}

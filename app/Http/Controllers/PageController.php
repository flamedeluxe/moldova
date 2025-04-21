<?php

namespace App\Http\Controllers;

use App\Models\Page;

class PageController extends Controller
{
    public function show($alias)
    {
        $page = Page::query()->where('alias', $alias)->firstOrFail();
        return view('pages.page', compact('page'));
    }
}

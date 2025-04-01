<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\Site\PublicationService;

class TextController extends Controller
{
    public function show($alias)
    {
        $page = Page::where('alias', $alias)->firstOrFail();
        return view('text', compact('page'));
    }
}

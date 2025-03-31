<?php

namespace App\Http\Controllers;

use App\Models\Page;

class AboutController extends BaseController
{
    public function index()
    {
        $page = Page::query()->findOrFail(1);
        return view('pages.about', compact('page'));
    }
}

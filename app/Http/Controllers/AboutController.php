<?php

namespace App\Http\Controllers;

use App\Models\Page;

class AboutController extends BaseController
{
    public function index()
    {
        $resource = (object)[
            'title' => 'О нас',
            'description' => ''
        ];

        $page = Page::query()->findOrFail(1);
        return view('pages.about', compact('page', 'resource'));
    }
}

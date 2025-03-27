<?php

namespace App\Http\Controllers;

use App\Models\Publication;

class ProjectController extends BaseController
{
    public function index()
    {
        $news = Publication::active()
            ->where('type', 'news')
            ->orderBy('published_at', 'DESC')
            ->get();

        $events = Publication::active()
            ->where('type', 'event')
            ->orderBy('published_at', 'DESC')
            ->get();

        return view('pages.projects.index', compact('news', 'events'));
    }
}

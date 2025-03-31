<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Publication;

class IndexController extends BaseController
{
    public function index()
    {
        $news = Publication::active()
            ->where('type', 'news')
            ->orderBy('published_at', 'desc')
            ->take(9)
            ->get();

        $events = Publication::active()
            ->where('type', 'event')
            ->orderBy('published_at', 'desc')
            ->take(9)
            ->get();

        $projects = Project::activeSorted()->get();

        return view('pages.index', compact('news', 'events', 'projects'));
    }
}

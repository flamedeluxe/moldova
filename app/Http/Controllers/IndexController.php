<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\Site\PublicationService;

class IndexController extends BaseController
{
    public function index()
    {
        $news = (new PublicationService)->getPublications('news');
        $events = (new PublicationService)->getPublications('event', session('city'));
        $projects = Project::activeSorted()->get();

        return view('pages.index', [
            'categories' => $events['categories'],
            'news' => $news['items'],
            'news_total' => $news['total'],
            'events' => $events['items'],
            'events_total' => $events['total'],
            'projects' => $projects,
        ]);
    }
}

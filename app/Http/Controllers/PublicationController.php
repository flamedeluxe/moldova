<?php

namespace App\Http\Controllers;

use App\Models\Publication;

class PublicationController extends BaseController
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

        return view('pages.publications.index', compact('news', 'events'));
    }

    public function show($slug)
    {
        $publication = Publication::query()->where('slug', $slug)->firstOrFail();
        return view('pages.publications.show', compact('publication'));
    }
}

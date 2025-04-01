<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Services\Site\PublicationService;

class PublicationController extends BaseController
{
    public function index()
    {
        $news = (new PublicationService)->getPublications('news');
        $events = (new PublicationService)->getPublications('event', session('city'));

        if(request()->ajax()) {
            $data = match (request()->get('type')) {
                'events' => $events,
                default => $news,
            };
            return response()->json([
                'data' => $data['items'],
                'total' => $data['total']
            ]);
        }

        return view('pages.publications.index', [
            'categories' => $events['categories'],
            'events' => $events['items'],
            'news' => $news['items'],
            'news_total' => $news['total'],
            'events_total' => $events['total'],
            'eventDates' => $events['dates']
        ]);
    }

    public function show($slug)
    {
        $publication = Publication::query()->where('slug', $slug)->firstOrFail();
        return view('pages.publications.show', compact('publication'));
    }
}

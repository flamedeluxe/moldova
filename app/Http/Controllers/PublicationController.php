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

        $dates = [];
        foreach($events['dates'] as $date) {
            $dates[] = [
                'day' => $date->day,
                'month' => mb_substr($date->locale('ru')->monthName, 0, 3),
                'date' => $date->locale('ru')->format('%Y-%m-%d')
            ];
        }

        return view('pages.publications.index', [
            'categories' => $events['categories'],
            'events' => $events['items'],
            'news' => $news['items'],
            'news_total' => $news['total'],
            'events_total' => $events['total'],
            'dates' => $dates
        ]);
    }

    public function show($slug)
    {
        $publication = Publication::active()->where('slug', $slug)->firstOrFail();
        $publications = Publication::active()
            ->orderBy('published_at', 'desc')
            ->where('type', 'news')
            ->where('id', '!=', $publication->id)
            ->limit(6)
            ->get();
        return view('pages.publications.show', compact('publication', 'publications'));
    }
}

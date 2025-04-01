<?php

namespace App\Http\Controllers;

use App\Services\Site\PublicationService;

class ErrorController extends Controller
{

    public function show404()
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

        return response()->view('errors.404', [
            'categories' => $events['categories'],
            'events' => $events['items'],
            'news' => $news['items'],
            'news_total' => $news['total'],
            'events_total' => $events['total'],
            'eventDates' => $events['dates']
        ], 404);
    }
}

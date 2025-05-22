<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Services\Site\PublicationService;

class EventController extends BaseController
{
    public function index()
    {
        $events = (new PublicationService)->getPublications('event', session('city'));

        if(request()->ajax()) {
            return response()->json([
                'categories' => $events['categories'],
                'data' => $events['items'],
                'total' => $events['total']
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

        $resource = (object)[
            'title' => 'Афиша',
            'description' => ''
        ];

        return view('pages.events.index', [
            'categories' => $events['categories'],
            'events' => $events['items'],
            'events_total' => $events['total'],
            'dates' => $dates,
            'resource' => $resource
        ]);
    }

    public function show($slug)
    {
        $publication = Publication::active()->where('slug', $slug)->firstOrFail();
        $events = Publication::active()
            ->orderBy('published_at', 'desc')
            ->where('type', 'event')
            ->where('id', '!=', $publication->id)
            ->limit(3)
            ->get();

        $resource = $publication;

        return view('pages.events.show', compact('publication','events', 'resource'));
    }
}

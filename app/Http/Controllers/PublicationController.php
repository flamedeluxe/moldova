<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Services\Site\PublicationService;

class PublicationController extends BaseController
{
    public function news()
    {
        $news = (new PublicationService)->getPublications('news');

        if(request()->ajax()) {
            return response()->json([
                'categories' => $news['categories'],
                'data' => $news['items'],
                'total' => $news['total']
            ]);
        }

        $dates = [];
        foreach($news['dates'] as $date) {
            $dates[] = [
                'day' => $date->day,
                'month' => mb_substr($date->locale('ru')->monthName, 0, 3),
                'date' => $date->locale('ru')->format('%Y-%m-%d')
            ];
        }

        $resource = (object)[
            'title' => 'Публикации',
            'description' => ''
        ];

        return view('pages.publications.index', [
            'news' => $news['items'],
            'news_total' => $news['total'],
            'dates' => $dates,
            'resource' => $resource
        ]);
    }


    public function show($slug)
    {
        $publication = Publication::active()->where('slug', $slug)->firstOrFail();
        $news = Publication::active()
            ->orderBy('published_at', 'desc')
            ->where('type', 'news')
            ->where('id', '!=', $publication->id)
            ->limit(3)
            ->get();
        $events = Publication::active()
            ->orderBy('published_at', 'desc')
            ->where('type', 'news')
            ->where('id', '!=', $publication->id)
            ->limit(3)
            ->get();

        $resource = $publication;

        return view('pages.publications.show', compact('publication', 'news', 'events', 'resource'));
    }
}

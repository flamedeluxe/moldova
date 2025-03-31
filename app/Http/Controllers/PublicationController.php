<?php

namespace App\Http\Controllers;

use App\Models\Publication;

class PublicationController extends BaseController
{
    public function index()
    {
        $news = Publication::active()
            ->where('type', 'news')
            ->orderBy('published_at', 'DESC');

        if(request()->page && request()->page >= 1) {
            $news = $news->offset((request()->page - 1) * 6);
        }

        if(request()->date) {
            $dates = $this->parseDateRange(request()->date);
            $news = $news->whereDate('published_at', '>=', date('Y-m-d', strtotime($dates[0])))
                ->whereDate('published_at', '<=', date('Y-m-d', strtotime($dates[1])));
        }

        $categories = Publication::whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        $categories = array_merge(['Все'], $categories->toArray());

        $events = Publication::active()
            ->where('type', 'event')
            ->orderBy('published_at', 'DESC');

        if(request()->page && request()->page > 1) {
            $events = $events->offset((request()->page - 1) * 6);
        }
        if(request()->cateogry && request()->cateogry != 'Все') {
            $events = $events->where('category', request()->cateogry);
        }

        $news = $news->limit(6)->get();
        $events = $events->limit(6)->get();

        if(request()->ajax()) {

            if(request()->type == 'news') {
                $data = $news;
            }
            if(request()->type == 'events') {
                $data = $events;
            }

            return response()->json($data);
        }

        return view('pages.publications.index', [
            'news' => $news,
            'categories' => $categories,
            'events' => $events,
            'news_total' => Publication::active()->where('type', 'news')->count(),
            'events_total' => Publication::active()->where('type', 'event')->count(),
        ]);
    }

    public function show($slug)
    {
        $publication = Publication::query()->where('slug', $slug)->firstOrFail();
        return view('pages.publications.show', compact('publication'));
    }
}

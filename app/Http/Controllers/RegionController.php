<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Publication;
use App\Models\User;

class RegionController extends BaseController
{
    public function index($slug)
    {
        $city = City::query()->where('slug', $slug)->firstOrFail();
        $user = User::query()->whereJsonContains('city', $city->title)->first();

        $news = Publication::active()
            ->where('type', 'news')
            ->where('city', $city->title)
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
            ->where('type', 'event')
            ->where('city', $city->title)
            ->distinct()
            ->pluck('category');

        $categories = array_merge(['Все'], $categories->toArray());

        $events = Publication::active()
            ->where('type', 'event')
            ->where('city', $city->title)
            ->orderBy('published_at', 'DESC');

        if(request()->page && request()->page > 1) {
            $events = $events->offset((request()->page - 1) * 6);
        }
        if(request()->category && request()->category != 'Все') {
            $events = $events->where('category', request()->category);
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

        return view('pages.region', [
            'city' => $city,
            'user' => $user,
            'news' => $news,
            'categories' => $categories,
            'events' => $events,
            'news_total' => Publication::active()->where('type', 'news')->count(),
            'events_total' => Publication::active()->where('type', 'event')->count(),
        ]);
    }
}

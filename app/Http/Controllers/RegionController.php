<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Services\Site\PublicationService;

class RegionController extends BaseController
{
    public function index($slug)
    {
        $city = City::query()->where('slug', $slug)->firstOrFail();
        $user = User::query()->whereJsonContains('city', $city->title)->first();

        session()->put('city', $city->title);

        $news = (new PublicationService)->getPublications('news', $city->title);
        $events = (new PublicationService)->getPublications('event', $city->title);

        return view('pages.region', [
            'city' => $city,
            'user' => $user,
            'categories' => $events['categories'],
            'news' => $news['items'],
            'events' => $events['items'],
            'news_total' => $news['total'],
            'events_total' => $events['total'],
            'eventDates' => $events['dates'],
        ]);
    }
}

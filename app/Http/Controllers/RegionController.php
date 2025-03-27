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

        $news = Publication::query()
            ->where('type', 'news')
            ->where('city', $city->title)
            ->orderBy('published_at', 'DESC')
            ->get();

        $events = Publication::query()
            ->where('type', 'event')
            ->where('city', $city->title)
            ->orderBy('published_at', 'DESC')
            ->get();

        return view('pages.region', compact('city', 'user', 'news', 'events'));
    }
}

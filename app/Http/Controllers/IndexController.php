<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Question;
use App\Models\Slider;
use App\Services\Site\PublicationService;

class IndexController extends BaseController
{
    public function index()
    {
        $news = (new PublicationService)->getPublications('news');
        $events = (new PublicationService)->getPublications('event', session('city'));
        $projects = Project::activeSorted()->get();
        $slides = Slider::find(1);
        $faq = Question::all();

        $dates = [];
        foreach($events['dates'] as $date) {
            $dates[] = [
                'day' => $date->day,
                'month' => mb_substr($date->locale('ru')->monthName, 0, 3),
                'date' => $date->locale('ru')->format('%Y-%m-%d')
            ];
        }

        return view('pages.index', [
            'categories' => $events['categories'],
            'news' => $news['items'],
            'news_total' => $news['total'],
            'events' => $events['items'],
            'events_total' => $events['total'],
            'projects' => $projects,
            'slides' => $slides->slides,
            'faq' => $faq,
            'dates' => $dates,
        ]);
    }
}

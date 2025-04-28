<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends BaseController
{
    public function index()
    {
        $resource = (object)[
            'title' => 'Часто задаваемые вопросы',
            'description' => ''
        ];

        $resources = Question::query()->active()->get();
        return view('pages.questions.index', compact('resources', 'resource'));
    }

    public function show($slug)
    {
        $page = Question::query()->where('slug', $slug)->firstOrFail();
        $resource = $page;
        return view('pages.questions.show', compact('page', 'resource'));
    }
}

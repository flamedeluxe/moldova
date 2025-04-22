<?php

namespace App\Http\Controllers;

use App\Models\Question;

class QuestionController extends BaseController
{
    public function index()
    {
        $resources = Question::query()->active()->get();
        return view('pages.questions.index', compact('resources'));
    }

    public function show($slug)
    {
        $page = Question::query()->where('slug', $slug)->firstOrFail();
        return view('pages.questions.show', compact('page'));
    }
}

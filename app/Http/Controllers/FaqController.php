<?php

namespace App\Http\Controllers;

use App\Models\Question;

class FaqController extends BaseController
{
    public function index()
    {
        $resources = Question::query()->active()->get();

        return view('pages.faq', compact('resources'));
    }
}

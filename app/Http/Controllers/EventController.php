<?php

namespace App\Http\Controllers;

class EventController extends BaseController
{
    public function index()
    {
        $resource = (object)[
            'title' => 'События',
            'description' => ''
        ];

        return view('pages.events.index', compact('resource'));
    }
}

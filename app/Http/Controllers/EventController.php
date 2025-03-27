<?php

namespace App\Http\Controllers;

class EventController extends BaseController
{
    public function index()
    {
        return view('pages.events.index');
    }
}

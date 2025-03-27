<?php

namespace App\Http\Controllers;

class AboutController extends BaseController
{
    public function index()
    {
        return view('pages.about');
    }
}

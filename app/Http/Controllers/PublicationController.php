<?php

namespace App\Http\Controllers;

class PublicationController extends BaseController
{
    public function index()
    {
        return view('pages.publications.index');
    }
}

<?php

namespace App\Http\Controllers;

class ProjectController extends BaseController
{
    public function index()
    {
        return view('pages.projects.index');
    }
}

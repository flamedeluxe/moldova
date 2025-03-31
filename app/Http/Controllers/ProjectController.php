<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Publication;

class ProjectController extends BaseController
{
    public function index()
    {
        $projects = Project::activeSorted()->get();
        return view('pages.projects.index', compact('projects'));
    }

    public function show(string $slug)
    {
        $project = Project::active()->where('slug', $slug)->firstOrFail();
        return view('pages.projects.show', compact('project'));
    }
}

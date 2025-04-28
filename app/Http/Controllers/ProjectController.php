<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Publication;

class ProjectController extends BaseController
{
    public function index()
    {
        $resource = (object)[
            'title' => 'Проекты',
            'description' => ''
        ];

        $projects = Project::activeSorted()->get();
        return view('pages.projects.index', compact('projects', 'resource'));
    }

    public function show(string $slug)
    {
        $project = Project::active()->where('slug', $slug)->firstOrFail();
        $news = Publication::active()
            ->orderBy('published_at', 'desc')
            ->where('type', 'news')
            ->limit(3)
            ->get();
        $events = Publication::active()
            ->orderBy('published_at', 'desc')
            ->where('type', 'news')
            ->limit(3)
            ->get();

        $resource = $project;
        return view('pages.projects.show', compact('project', 'news', 'events', 'resource'));
    }
}

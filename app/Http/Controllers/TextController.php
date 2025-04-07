<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\Site\PublicationService;

class TextController extends Controller
{
    public function show($alias)
    {

        switch ($alias) {
            case 'policy':
                $id = 2;
                break;
            default:
                abort(404);
        }

        $page = Page::findOrFail($id);
        return view('pages.text', compact('page'));
    }
}

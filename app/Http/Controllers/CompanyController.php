<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Company;
use App\Models\User;
use App\Services\Site\CompanyService;
use App\Services\Site\PublicationService;

class CompanyController extends BaseController
{
    public function index()
    {
        $companies = (new CompanyService())->get();
        $ways = Company::active()->distinct()->pluck('way', 'way');

        if(request()->ajax()) {
            return response()->json([
                'data' => $companies['items'],
                'total' => $companies['total'],
            ]);
        }

        return view('pages.companies.index', [
            'companies' => $companies['items'],
            'total' => $companies['total'],
            'ways' => $ways
        ]);
    }

    public function show($slug)
    {
        $company = Company::active()->where('slug', $slug)->firstOrFail();
        $companies = Company::active()->where('id', '!=', $company->id)->get();
        return view('pages.companies.show', compact('company', 'companies'));
    }
}

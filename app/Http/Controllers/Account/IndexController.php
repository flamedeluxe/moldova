<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Services\Site\PublicationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{

    public array $rules = [
        'surname' => 'required|string|max:100',
        'name' => 'required|string|max:100',
        'patronymic' => 'required|string|max:100',
        'birthday' => 'required|date|before:today',
        'phone' => 'required|string|max:100',
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'region' => 'required|exists:cities,title',
        'socials' => 'array|nullable|max:5',
    ];

    public function events()
    {
        $profile = Auth::user();
        $events = (new PublicationService)->getPublications('event', $profile->region);

        return response()->json([
            'events' => $events['items'],
            'events_total' => $events['total'],
        ]);
    }

    public function index()
    {
        $profile = Auth::user();
        $cities = City::active()->get();
        $events = (new PublicationService)->getPublications('event', $profile->region);
        $city = City::query()->where('title', $profile->region)->first();

        $count = 0;
        foreach($this->rules as $field => $rule) {
            if($profile->$field != '') $count++;
        }
        $profile->count = $count;

        $resource = (object)[
            'title' => 'Личный кабинет',
            'description' => ''
        ];

        return view('pages.account.index', [
            'profile' => $profile,
            'events' => $events['items'],
            'events_total' => $events['total'],
            'cities' => $cities,
            'city' => $city,
            'resource' => $resource
        ]);
    }

    public function save(Request $request)
    {
        $profile = Auth::user();

        $validated = $request->validate($this->rules);

        if(is_array($validated['socials'])) foreach($validated['socials'] as $idx => $item) {
            if($item == '') unset($validated['socials'][$idx]);
        }

        $profile->update($validated);

        $count = 0;
        foreach($this->rules as $field => $rule) {
            if($profile->$field !== '') $count++;
        }

        if($count >= 6 && $profile->bill < 350) {
            $profile->bill += 350;
            $profile->save();
        }

        $profile->count = $count;

        return response()->json([
            'success' => true,
            'profile' => $profile,
        ]);
    }
}

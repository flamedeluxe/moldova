<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\City;
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
        'email' => 'required|email|max:100',
        'region' => 'required|exists:cities,title',
        'socials' => 'array|nullable|max:5',
    ];

    public function index()
    {
        $profile = Auth::user();
        $cities = City::active()->get();

        $count = 0;
        foreach($this->rules as $field => $rule) {
            if($profile->$field !== '') $count++;
        }
        $profile->count = $count;

        if(request()->ajax()) {
            return response()->json($profile);
        }

        return view('pages.account.index', compact('profile', 'cities'));
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
            'profile' => $profile
        ]);
    }
}

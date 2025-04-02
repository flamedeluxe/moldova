<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        $profile = Auth::user();
        return view('pages.account.index', compact('profile'));
    }

    public function save(Request $request)
    {
        $profile = Auth::user();

        $validated = $request->validate([
            'surname' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'patronymic' => 'required|string|max:100',
            'birthday' => 'required|date|before:today',
            'phone' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'socials' => 'array|nullable|max:5',
        ]);

        foreach($validated['socials'] as $idx => $item) {
            if($item == '') unset($validated['socials'][$idx]);
        }

        $profile->update($validated);

        return response()->json([
            'success' => true,
            'profile' => $profile
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AccountController extends BaseController
{
    public function index()
    {
        return view('pages.account.index');
    }

    public function register()
    {
        if(Auth::check()) return redirect()->route('account.index');
        return view('pages.register');
    }

    public function login()
    {
        if(Auth::check()) return redirect()->route('account.index');
        return view('pages.login');
    }

    public function logout()
    {

    }

    public function confirmPassword()
    {
        return view('pages.reset-password');
    }

    public function forgotPassword()
    {

    }
}

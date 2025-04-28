<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AccountController extends BaseController
{
    public function index()
    {
        $resource = (object)[
            'title' => 'Личный кабинет',
            'description' => ''
        ];

        return view('pages.account.index', compact('resource'));
    }

    public function register()
    {
        $resource = (object)[
            'title' => 'Регистрация',
            'description' => ''
        ];

        if(Auth::check()) return redirect()->route('account.index');
        return view('pages.register', compact('resource'));
    }

    public function login()
    {
        $resource = (object)[
            'title' => 'Вход в личный кабинет',
            'description' => ''
        ];

        if(Auth::check()) return redirect()->route('account.index');
        return view('pages.login', compact('resource'));
    }

    public function logout()
    {

    }

    public function confirmPassword()
    {
        $resource = (object)[
            'title' => 'Сброс пароля',
            'description' => ''
        ];

        return view('pages.reset-password', compact('resource'));
    }

    public function forgotPassword()
    {

    }
}

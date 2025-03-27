<?php

namespace App\Http\Controllers;

class AccountController extends BaseController
{
    public function index()
    {
        return view('pages.account.index');
    }

    public function register()
    {
        return view('pages.register');
    }

    public function login()
    {
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

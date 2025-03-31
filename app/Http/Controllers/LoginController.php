<?php

namespace App\Http\Controllers;

use App\Mail\NewPasswordMail;
use App\Mail\RegisterMail;
use App\Mail\RestoreMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function form()
    {
        return view('admin.login');
    }

    public function auth(Request $request)
    {
        $request->headers->set('Accept', 'application/json');

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Login success!',
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'email' => 'Не верный пароль или e-mail'
            ]
        ]);
    }

    public function register_confirm($code): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        if(!$user = User::where('verification_code', $code)->first()) abort(404);
        $user->active = true;
        $user->verification_code = null;
        $user->save();

        Auth::login($user);

        return redirect('/account');
    }

    public function restore_confirm($code): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        if(!$user = User::where('verification_code', $code)->first()) abort(404);
        $user->active = true;
        $user->verification_code = null;
        $pass = \Str::random(8);
        $password = \Hash::make($pass);
        $user->password = $password;
        $user->save();

        Mail::to($user->email)->send(new NewPasswordMail([
            'password' => $pass
        ]));

        return redirect('/account');
    }

    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agree' => ['required', 'accepted'],
        ]);

        if (User::query()->where('email', $credentials['email'])->first()){
            return response()->json([
                'success' => false,
                'errors' => ['email' => 'Пользователь с таким e-mail уже зарегистрирован']
            ]);
        }

        $code = \Str::random(20);

        $user = User::query()->create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => \Hash::make($credentials['password']),
            'verification_code' => $code
        ]);

        $buyer = Buyer::query()->create([
            'title' => $user->name,
            'user_id' => $user->id,
            'alias' => \Str::random(16),
        ]);

        Mail::to($user->email)->send(new RegisterMail([
            'link' => env('APP_URL') . '/register/confirm/' . $code,
        ]));

        $message  = "Новый пользователь: \n";
        $message .= "Имя: " . $credentials['name'] . "\n";
        $message .= "Email: " . $credentials['email'];

        return response()->json([
            'success' => true,
            'message' => 'Вы были успешно зарегистрированы, на Вашу почту было отправлено письмо с подтверждением регистрации',
        ]);
    }

    public function restore(Request $request): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'message' => 'Ссылка для восстановления пароля успешно отправлена Вам на почту'
        ];

        if(!$user = User::query()->where('email', $request->get('email'))->first()) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => 'Пользователь с таким e-mail не зарегистрирован']
            ]);
        }

        $code = \Str::random(20);
        $user->verification_code = $code;
        $user->save();

        Mail::to($user->email)->send(new RestoreMail([
            'link' => env('APP_URL') . '/restore/confirm/' . $code,
        ]));

        return response()->json($response);
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('admin');
        }

        return back()->withErrors([
            'email' => 'Не верный пароль или e-mail'
        ])->onlyInput('email');
    }

    public function logout(Request $request): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function signin()
    {
        $resource = (object)[
            'title' => 'Личный кабинет',
        ];
        return view('site.login', compact('resource'));
    }
}

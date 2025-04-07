<?php

namespace App\Http\Controllers;

use App\Mail\NewPasswordMail;
use App\Mail\RestoreMail;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\Site\SmsService;
use stdClass;

class LoginController extends Controller
{

    public function getCode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required'],
        ]);

        $validated['phone'] = str_replace([' ', ')', '(', '-'], '', $validated['phone']);

        $citizen = Citizen::query()->where('phone', $validated['phone'])->first();
        $user = User::query()->where('phone', $validated['phone'])->first();

        $code = Str::random(4);
        self::sendSms($validated['phone'], 'Ваш проверочный код: ' . $code);

        if($citizen && !$user) {
            $user = User::query()->create([
                'name' => $citizen->name,
                'phone' => $validated['phone'],
                'password' => Hash::make(Str::random(20)),
                'verification_code' => $code,
                'active' => false,
                'role' => 'user',
                'card' => $citizen->card,
                'surname' => $citizen->surname,
                'patronymic' => $citizen->patronymic,
                'email' => $citizen->email,
                'number' => $citizen->id_number,
                'ext_id' => $citizen->ext_id
            ]);
            $citizen->delete();
        }

        if($user) {
            return response()->json([
                'success' => true,
                'message' => 'Код выслан на ваш телефон',
            ]);
        }

        return response()->json([
            'errors' => [
                'phone' => ['Пользователь не зарегистрирован']
            ]
        ], 422);
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $credentials = $request->validate([
            'phone' => ['required'],
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
                'phone' => ['Не верный пароль']
            ]
        ]);
    }

    public function register_confirm($code): RedirectResponse
    {
        if(!$user = User::query()->where('verification_code', $code)->first()) abort(404);
        $user->active = true;
        $user->verification_code = null;
        $user->save();

        Auth::login($user);

        return redirect('/account');
    }

    public function restore_confirm($code): RedirectResponse
    {
        if(!$user = User::query()->where('verification_code', $code)->first()) abort(404);
        $user->active = true;
        $user->verification_code = null;
        $pass = Str::random(8);
        $password = Hash::make($pass);
        $user->password = $password;
        $user->save();

        Mail::to($user->email)->send(new NewPasswordMail([
            'password' => $pass
        ]));

        return redirect('/account');
    }

    public function register(Request $request): JsonResponse
    {
        $request->headers->set('Accept', 'application/json');

        $credentials = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required'],
            'password' => ['required', 'string', 'min:8'],
            'agree' => ['required', 'accepted'],
        ]);

        $credentials['phone'] = str_replace([' ', ')', '(', '-'], '', $credentials['phone']);

        if (User::query()->where('phone', $credentials['phone'])->first()){
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => ['Пользователь с таким телефоном уже зарегистрирован']
                ]
            ], 422);
        }

        $code = Str::random(4);

        self::sendSms($credentials['phone'], 'Ваш проверочный код: ' . $code);

        $user = User::query()->create([
            'name' => $credentials['name'],
            'phone' => $credentials['phone'],
            'password' => Hash::make($credentials['password']),
            'verification_code' => $code,
            'active' => false,
            'role' => 'user'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Вы были успешно зарегистрированы',
        ]);
    }

    function checkCode(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required'],
        ]);

        $user = User::query()->where('verification_code', $validated['code'])->first();

        if($user) {
            $user->active = true;
            $user->verification_code = null;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Вы были успешно авторизированны'
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'code' => ['Не верный проверочный код']
            ]
        ], 422);
    }

    public function restore(Request $request): JsonResponse
    {
        $response = [
            'success' => true,
            'message' => 'Ссылка для восстановления пароля успешно отправлена Вам на почту'
        ];

        if(!$user = User::query()->where('email', $request->get('email'))->first()) {
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => ['Пользователь с таким телефоном не зарегистрирован']
                ]
            ], 422);
        }

        $code = \Str::random(20);
        $user->verification_code = $code;
        $user->save();

        Mail::to($user->email)->send(new RestoreMail([
            'link' => env('APP_URL') . '/restore/confirm/' . $code,
        ]));

        return response()->json($response);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private static function sendSms($to, $text)
    {
        $sigma = new SmsService(env('SIGMA_API_TOKEN'));

        $params = array(
            "type"       => "sms",
            "recipient"  => $to,
            "payload"    => array(
                "sender" => "B-Media",
                "text"   => $text
            )
        );

        return $sigma->send_msg($params);
    }
}

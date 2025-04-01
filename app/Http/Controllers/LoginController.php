<?php

namespace App\Http\Controllers;

use App\Mail\NewPasswordMail;
use App\Mail\RestoreMail;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use SmsService;
use stdClass;

class LoginController extends Controller
{
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
                'phone' => 'Не верный пароль'
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
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agree' => ['required', 'accepted'],
        ]);

        if (User::query()->where('phone', $credentials['phone'])->first()){
            return response()->json([
                'success' => false,
                'errors' => ['phone' => 'Пользователь с таким телефоном уже зарегистрирован']
            ]);
        }

        $code = Str::random(20);

        $user = User::query()->create([
            'name' => $credentials['name'],
            'phone' => $credentials['phone'],
            'password' => Hash::make($credentials['password']),
            'verification_code' => $code
        ]);

        self::sendSms($credentials['phone'], 'Ваш проверочный код: ' . $code);

        return response()->json([
            'success' => true,
            'message' => 'Вы были успешно зарегистрированы, на Вашу почту было отправлено письмо с подтверждением регистрации',
        ]);
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

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private static function sendSms($to, $text): bool
    {
        $smsru = new SmsService('54C1C05D-77F9-5A84-0A60-F35526FD4206');
        $data = new stdClass();
        $data->to = $to;
        $data->text = $text;
        $sms = $smsru->send_one($data);

        if ($sms->status == "OK") {
            echo "Сообщение отправлено успешно. ";
            echo "ID сообщения: $sms->sms_id. ";
            echo "Ваш новый баланс: $sms->balance";
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
        }

        return $sms->status === "OK";
    }
}

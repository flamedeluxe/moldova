<?php

namespace App\Http\Controllers;

use App\Mail\RestoreMail;
use App\Models\Citizen;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\Site\SmsService;
use stdClass;

class LoginController extends Controller
{

    public function getCode(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required',
        ]);

        if($this->sendCode($validated['phone'])) {
            return response()->json([
                'success' => true,
                'message' => 'Код выслан на ваш номер телефона',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Пользователь не найден',
        ], 422);
    }

    public function sendCode(string $phone): bool
    {
        $phone = preg_replace('/[\s\-\(\)]+/', '', $phone);

        if(!$user = User::query()->firstOrCreate(
            ['phone' => $phone],
            [
                'phone' => $phone,
                'name' => 'unknown',
            ]
        )) {
            return false;
        }
        $code = env('SMS_TEST') ? 9999 : rand(1111, 9999);
        $user->update(['verification_code' => $code]);
        self::sendSms($phone, 'Ваш проверочный код: ' . $code);

        return true;
    }

    public function checkCode(string $code): bool
    {
        if($user = User::query()->where(['verification_code' => $code])->first()) {
            Auth::login($user);
            $user->update(['verification_code' => null]);
            return true;
        }

        return false;
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required'],
        ]);

        $validated['phone'] = str_replace(['+', ' ', ')', '(', '-'], '', $validated['phone']);

        $citizen = Citizen::query()->where('phone', $validated['phone'])->first();
        $user = User::query()->where(['phone' => $validated['phone']])->first();

        $result = $this->sendCode($validated['phone']);

        if($citizen && !$user) {
            User::query()->create([
                'name' => $citizen->name,
                'phone' => $validated['phone'],
                'password' => Hash::make(Str::random(20)),
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

        if($result) {
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

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^(\S+\s+){2,}\S+$/u'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'agree' => ['required', 'accepted'],
        ]);

        $validated['phone'] = str_replace(['+', ' ', ')', '(', '-'], '', $validated['phone']);

        if (User::query()->where('phone', $validated['phone'])->first()){
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => ['Пользователь с таким телефоном уже зарегистрирован']
                ]
            ], 422);
        }

        $fio = explode(' ', $validated['name']);
        User::query()->create([
            'name' => $fio[0],
            'surname' => $fio[1],
            'patronymic' => $fio[2],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'active' => false,
            'role' => 'user'
        ]);

        $result = $this->sendCode($validated['phone']);

        return response()->json([
            'success' => true,
            'message' => 'Вы были успешно зарегистрированы',
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
                'errors' => [
                    'phone' => ['Пользователь с таким телефоном не зарегистрирован']
                ]
            ], 422);
        }

        $code = env('SMS_TEST') ? 9999 : rand(1111, 9999);
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
        return redirect('/');
    }

    private static function sendSms($to, $text): void
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

        $result = $sigma->send_msg($params);

        Log::info(json_encode($result));
    }
}

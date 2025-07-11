<?php

namespace App\Http\Controllers;

use App\Mail\RestoreMail;
use App\Models\Citizen;
use App\Models\User;
use App\Services\Site\MangoOffice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Services\Site\MangoService;
use stdClass;

class LoginController extends Controller
{

    public function getCode(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required',
        ]);

        $phone = $this->cleanPhone($validated['phone']);

        $user = User::query()->where(['phone' => $phone])->first();

        if($user) {
            $code = env('SMS_TEST') ? 9999 : rand(1111, 9999);
            $user->update(['verification_code' => $code]);
            $this->sendSms($phone, 'Ваш проверочный код: ' . $code);

            return response()->json([
                'success' => true,
                'message' => 'Код выслан на ваш номер телефона',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Пользователь не найден',
            'errors' => [
                'phone' => ['Пользователь не найден']
            ]
        ], 422);
    }

    public function confirm_register(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required',
            'code' => 'required',
        ]);

        $validated['phone'] = $this->cleanPhone($validated['phone']);
        if($user = User::query()->where(['verification_code' => $validated['code'], 'phone' => $validated['phone']])->first()) {
            $user->update(['verification_code' => null, 'active' => 1]);
            Auth::login($user);
            return response()->json([
                'success' => true,
                'message' => 'Вы были успешно зарегистрированы'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Не верный код',
            'errors' => [
                'code' => ['Не верный код']
            ]
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required'],
            'code' => ['required'],
        ]);

        $validated['phone'] = $this->cleanPhone($validated['phone']);

        if(!$user = User::query()->where(['verification_code' => $validated['code'], 'phone' => $validated['phone']])->first()) {
            return response()->json([
                'success' => true,
                'message' => 'Не верно введен код',
                'errors' => [
                    'code' => ['Не верно введен код']
                ]
            ], 422);
        }

        $user->update(['verification_code' => null, 'active' => 1]);

        Auth::login($user);

        return response()->json([
            'success' => true,
            'message' => 'Вы были успешно авторизированны'
        ]);
    }

    public function register(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^(\S+\s+){2,}\S+$/u'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'agree' => ['required', 'accepted'],
        ], [
            'name.required' => 'Введите полностью Фамилия Имя Отчество',
        ]);

        $validated['phone'] = $this->cleanPhone($validated['phone']);

        if (User::query()->where('phone', $validated['phone'])->first()){
            return response()->json([
                'success' => false,
                'errors' => [
                    'phone' => ['Пользователь с таким телефоном уже зарегистрирован']
                ]
            ], 422);
        }

        $fio = explode(' ', $validated['name']);
        $user = User::query()->create([
            'name' => $fio[0],
            'surname' => $fio[1],
            'patronymic' => $fio[2],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make(Str::random(10)),
            'active' => false,
            'role' => 'user'
        ]);

        if($citizen = Citizen::query()
            ->where('phone', str_replace('+', '', $validated['phone']))
            ->first()
        ) {
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
        }

        $code = env('SMS_TEST') ? 9999 : rand(1111, 9999);
        $user->update(['verification_code' => $code]);
        $this->sendSms($validated['phone'], 'Ваш проверочный код: ' . $code);

        return response()->json([
            'success' => true,
            'message' => 'Код выслан на ваш номер телефона',
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

    private function sendSms($to, $text): void
    {
        $to = str_replace('+', '', $to);
        $mango = new MangoOffice(env('MANGO_API_KEY'), env('MANGO_API_SALT'));
        $result = $mango->sendSms($text, '908', $to, 'KOZHM');
        Log::info(json_encode($result));
    }

    public function cleanPhone(string $phone): string
    {
        return preg_replace('/[\s\-\(\)]+/', '', $phone);
    }
}

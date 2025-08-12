<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use App\Models\Feedback;
use App\Models\Help;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Services\Site\MangoOffice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class FormController extends BaseController
{
    public function feedback(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|min:11|max:20',
            'text' => 'required|max:500',
            'agree' => 'accepted',
        ]);

        $data = $request->except('_token', 'agree');
        Feedback::query()->create($data);

        Mail::to(env('MAIL_FEEDBACK_TO'))->send(new FeedbackMail($data));

        return response()->json([
            'success' => true,
            'message' => 'Запрос успешно отправлен'
        ]);
    }

    public function feedbackModal(Request $request)
    {
        if(!empty($request->code) && !empty($request->phone)) {
            $code = Cache::get('code_' . $request->phone);
            
            if($code && $code == $request->code) {
                Help::query()->create($request->all());
                Mail::to(env('MAIL_FEEDBACK_TO'))->send(new FeedbackMail($request->all()));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Спасибо за обращение! Мы свяжемся с вами в ближайшее время.'
                ]);
            }
        }

        $validated = $request->validate([
            'surname' => 'required|max:255',
            'name' => 'required|max:255',
            'patrynomic' => 'required|max:255',
            'phone' => 'required|min:11|max:20',
            'email' => 'required|email',
            'text' => 'required|max:500',
            'agree' => 'accepted',
        ]);

        $phone = $this->cleanPhone($validated['phone']);
        $code = env('SMS_TEST') ? 9999 : rand(1111, 9999);
        $this->sendSms($phone, 'Ваш проверочный код: ' . $code);
        Cache::put('code_' . $phone, $code, 60 * 5);

        return response()->json([
            'success' => true,
            'message' => 'Запрос успешно отправлен'
        ]);
    }

    public function question(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'contacts' => 'required',
            'text' => 'required|max:500',
            'agree' => 'accepted',
        ]);

        $data = $request->except('_token', 'agree');

        Feedback::query()->create($data);

        Mail::to(env('MAIL_QUESTION_TO'))->send(new FeedbackMail($data));

        return response()->json([
            'success' => true,
            'message' => 'Запрос успешно отправлен'
        ]);
    }

    public function cleanPhone(string $phone): string
    {
        return preg_replace('/[\s\-\(\)]+/', '', $phone);
    }

    private function sendSms($to, $text): void
    {
        $to = str_replace('+', '', $to);
        $mango = new MangoOffice(env('MANGO_API_KEY'), env('MANGO_API_SALT'));
        $result = $mango->sendSms($text, '908', $to, 'KOZHM');
        Log::info(json_encode($result));
    }
}

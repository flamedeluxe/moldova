<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        Mail::to(env('MAIL_TO'))->send(new FeedbackMail($data));

        return response()->json([
            'success' => true,
            'message' => 'Запрос успешно отправлен'
        ]);
    }
}

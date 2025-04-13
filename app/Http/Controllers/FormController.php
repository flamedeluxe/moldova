<?php

namespace App\Http\Controllers;

use App\Mail\FeedbackMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends BaseController
{
    public function feedback(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'phone' => 'required|min:11|max:20',
            'text' => 'required|max:500',
            'agree' => 'accepted',
        ]);

        Mail::to(env('MAIL_TO'))->send(new FeedbackMail($validated));

        return response()->json([
            'success' => true,
            'message' => 'Запрос успешно отправлен'
        ]);
    }
}

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail as Mail;

class FrontendEmailController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'lastname' => 'required|min:2|max:255',
            'email' => 'required|min:8|max:255',
            'phone' => 'required|min:10|max:11',
            'message' => 'required|min:30',
        ]);
        $email = $request->email;
        $emailFrom = 'noreply@gaziantepbilisim.com.tr';
        $text = $request->text;
        $emailTo = 'hg.deliaslan@gmail.com';
        Mail::raw($text, function ($message) use ($emailFrom, $emailTo, $email) {
            $message->subject($email);
            $message->from($emailFrom);
            $message->to($emailTo);
        });

        return redirect()->route('index');
    }
}

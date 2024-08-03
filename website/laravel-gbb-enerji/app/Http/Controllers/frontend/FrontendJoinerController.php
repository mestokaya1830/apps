<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Joiners;
use Illuminate\Http\Request;

class FrontendJoinerController extends Controller
{
    public function signupForm()
    {
        return view('frontend.joiners.signup');
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:255',
            'lastname' => 'required|min:2|max:255',
            'identity' => 'required|min:11|max:11',
            'phone' => 'required|min:10|max:11',
        ]);
        if ($validated) {
            $checkRegister = Joiners::where('identity', $request->identity)->first();
            if ($checkRegister) {
                return redirect()->route('joiner.signup.form')->withErrors('Bu TC ile Katılım Bulunmaktadır');
            } else {
                Joiners::create([
                    'name' => $request->name,
                    'lastname' => $request->lastname,
                    'identity' => $request->identity,
                    'phone' => $request->phone,
                ]);
                $getJoinerId = Joiners::where('identity', $request->identity)->first('id');
                $request->session()->put('id', $getJoinerId->id);
                $request->session()->put('joinerid', $request->identity);
                $request->session()->put('name', $request->name);

                return redirect()->route('questions', 1);
            }
        }
    }
}

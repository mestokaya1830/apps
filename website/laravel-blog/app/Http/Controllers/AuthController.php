<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function register(Request $request){
        $newUser = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email','unique:users'],
            'password' => ['required', 'max:255', 'confirmed'],
        ]);
        $registeredUser = User::create($newUser);
        Auth::login($registeredUser);
        return redirect()->route('client.index');
   }
   public function login(Request $request){
        $loginUser = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);
        if(Auth::attempt($loginUser, $request->remember)){
            return redirect()->route('admin.index');
        } else {
            return back()->withErrors([
                'credential' => 'Wrong credential!'
            ]);
        }
   }
   public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('client.index');
   }
}

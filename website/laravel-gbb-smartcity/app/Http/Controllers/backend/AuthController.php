<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function Login()
    {
        return view('backend.pages.login');
    }

    public function LoginPost(Request $request)
    {
        $data['result'] = DB::table('admins')->where('name', $request->name, 1)->get();
        if (count($data['result']) > 0 && $request->password === $data['result'][0]->password) {
            $request->session()->put('admin', $request->name);
            return '200';
        } else {
            return '401';
        }
    }

    public function Logout(Request $request)
    {
        if ($request->session()->exists('admin')) {
            $request->session()->forget('admin');
        }
    }

    public function ResetPassword()
    {
        return view('backend.pages.resetpass');
    }

    public function ResetPasswordPost(Request $request)
    {
        $data['result'] = DB::table('admins')->where('email', $request->email, 1)->get();
    if(count($data['result']) > 0){
        DB::table('admins')->where('email', $request->email)->update([
            'password' => $request->password
        ]);
        return redirect('/login');
    } else {
        $data['message'] = 'Geçersiz oturum!';
        return view('backend.pages.resetpass', $data);
    }
    }
}

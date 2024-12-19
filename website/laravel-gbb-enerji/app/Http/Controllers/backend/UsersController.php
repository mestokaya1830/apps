<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersCreateRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('backend.users.index', compact('users'));
    }

    public function create()
    {
        return view('backend.users.create');
    }

    public function store(UsersCreateRequest $request)
    {
        $checkUser = User::where('email', $request->email)->get();
        if (count($checkUser) > 0) {
            return redirect()->route('users.index')->withErrors('Bu Kullanıcı Sistemde Kayıtlı');
        } else {
            $request->merge(['password' => Hash::make($request->password)]);
            User::create($request->post());

            return redirect()->route('users.index')->withSuccess('Kullanıcı Başarıyla Oluşturuldu');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $users = User::find($id) ?? abort('404', 'Kullaınıcı Bulunamadı');

        return view('backend.users.edit', compact('users'));
    }

    public function update(UsersUpdateRequest $request, $id)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        User::where('id', $id)->update($request->except(['_method', '_token']));

        return redirect()->route('users.index')->withSuccess('Kullanıcı Başarıyla Güncellendi');
    }

    public function destroy($id)
    {
        $getRole = User::where('id', $id)->first();
        if (Auth::id() == $id || $getRole->role == 'admin') {
            return redirect()->route('users.index')->withErrors('Bu Kaydı Silme Yetkiniz Yoktur');
        } else {
            User::where('id', $id)->delete();

            return redirect()->route('users.index')->withSuccess('Kullanıcı Başarıyla Silindi');
        }
    }
}

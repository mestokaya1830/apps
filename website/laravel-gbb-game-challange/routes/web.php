<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail as Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    $data['winner'] = DB::table('contestants')->where('status', 'Kazandı', 1)->orderBy('line')->get();
    return view('pages.home', $data);
});

Route::get('/contestantscount', function () {
    $data['contestants'] = DB::table('contestants')->get();
    return $data;
});

Route::get('/login', function () {
    return view('pages.login');
});

Route::post('/login', function (Request $req) {
    $data['result'] = DB::table('admins')->where('name', $req->name, 1)->get();
    if(count($data['result']) > 0 && $req->password === $data['result'][0]->password){
        $req->session()->put('admin', $req->name);
       return '200';
    } else {
       return '401';
    }
});

Route::get('/resetpass', function () {
    return view('pages.resetpass');
});

Route::post('/resetpass', function (Request $req) {
    $data['result'] = DB::table('admins')->where('email', $req->email, 1)->get();
    if(count($data['result']) > 0){
        DB::table('admins')->where('email', $req->email)->update([
            'password' => $req->password
        ]);
        return redirect('/login');
    } else {
        $data['message'] = 'Geçersiz oturum!';
        return view('pages.resetpass', $data);
    }
});

Route::get('/register', function () {
    return view('pages.register');
});

Route::post('/register', function (Request $req) {
    $fileName = $req->email.'.'.$req->file->getClientOriginalExtension();
    $req->file->storeAs('public', $fileName);//store to storage/public folder
    DB::table('contestants')->insert([
        'name'=>$req->firstName,
        'lastname'=> $req->lastName,
        'email'=>$req->email,
        'phone'=>$req->phone,
        'address'=>$req->address,
        'identity'=>$req->identity,
        'birthDate'=> $req->birthDate,
        'city'=>$req->city,
        'education'=>$req->education,
        'about'=>$req->about,
        'filename'=>$fileName
    ]);
    return '200';
});

Route::post('/deletecontestant', function (Request $req){
    $data =  DB::table('contestants')->where('id', $req->id)->get();
    if($data){
        Storage::disk('local')->delete('public/'.$data[0]->filename);
        DB::table('contestants')->where('id', $req->id)->delete();
        return '200';
    }
});

Route::delete('/logout', function (Request $req){
    if ($req->session()->exists('admin')) {
        $req->session()->forget('admin');
    }
});

Route::middleware('checkSession')->get('/contestants', function () {
    return view('pages.contestants');
});

Route::middleware('checkSession')->get('/getcontestants', function () {
    $data['contestants'] = DB::table('contestants')->get();
    return $data;
});

Route::get('/rules', function () {
    return view('pages.rules');
});

Route::middleware('checkSession')->get('/details/{id}', function ($id) {
    $data['contestants'] = DB::table('contestants')->where('id', $id)->get();
    $data['filename'] = $data['contestants'][0]->filename;
    return view('pages.details', $data);
});

Route::put('/details/setline', function (Request $req) {
    DB::table('contestants')->where('id', $req->id)->update([
        'status' => 'Kazandı',
        'line' => $req->line
    ]);
    return $req;
});

Route::put('/details/setstatus', function (Request $req) {
    DB::table('contestants')->where('id', $req->id)->update([
        'status' => $req->status,
        'line' => ''
    ]);
    return $req;
});

Route::post('/email', function(Request $req){
    $emailTo = $req->email;
    $subject = $req->subject;
    $text = $req->text;
    Mail::raw($text, function($message) use($emailTo, $subject) {
        $message->subject($subject);
        $message->to($emailTo);
    });
    return redirect('contestants');
})->name('email');

// file list and download
Route::get('/admin/contestantsfiles', function(){
    $data['files'] = Storage::disk('public')->files('');
    return view('pages.contestantsfiles', $data);
});

Route::get('downloadfile/{filename}', function($filename){
    return Storage::download('public/'.$filename);
});

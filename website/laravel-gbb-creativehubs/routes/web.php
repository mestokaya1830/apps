<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/getdata', function () {
    $data['nodes'] =  DB::table('nodes')->get(['id', 'sh', 'bg', 'bw', 'bc']);
    $data['edges'] =  DB::table('edges')->get();
    return $data;
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $req) {
    $data['result'] = DB::table('admins')->where('name', $req->name, 1)->get();
    if (count($data['result']) > 0 && $req->password === $data['result'][0]->password) {
        $req->session()->put('admin', $req->name);
        return '200';
    } else {
        return '401';
    }
});

Route::delete('/logout', function (Request $req) {
    if ($req->session()->exists('admin')) {
        $req->session()->forget('admin');
    }
});

Route::get('/resetpass', function () {
    return view('resetpass');
});

Route::post('/resetpass', function ($req) {
    $data['result'] = DB::table('admins')->where('email', $req->email, 1)->get();
    if (count($data['result']) > 0) {
        DB::table('admins')->where('email', $req->email)->update([
            'password' => $req->password
        ]);
        return redirect('/login');
    } else {
        $data['message'] = 'Geçersiz oturum!';
        return view('resetpass', $data);
    }
});

//admin side
Route::group(['middleware' => 'checkSession'], function () {
    Route::get('/addnode', function () {
        $data['nodes'] =  DB::table('nodes')->get(['id']);
        return view('addnode', $data);
    });

    Route::post('/addnode', function (Request $req) {
        $data['result'] = DB::table('nodes')->where('id', $req->id, 1)->get('id');
        if (count($data['result']) > 0) {
            $data['msg'] = 'Bu node zaten var!';
            return $data;
        } else {
            DB::table('nodes')->insert([
                'id' => $req->id,
                'type' => $req->type,
                'source' => $req->source,
                'source2' => $req->source2,
                'source3' => $req->source3,
                'text' => $req->text,
                'link' => $req->link,
                'location' => $req->location,
                'address' => $req->address,
                'category' => $req->category
            ]);
            $data['msg'] = 'Yeni node eklendi!';
            return $data;
        }
    });

    Route::post('/connectedge', function (Request $req) {
        $data['checkNode'] = DB::table('nodes')->where('id', $req->edgeTarget)->get('id');
        $data['checkEdgeSource'] = DB::table('nodes')->where('id', $req->edgeSource)->get('id');
        $data['checkEdgeId'] = DB::table('edges')->where('id', $req->edgeId, 1)->get('id');

        if (count($data['checkNode']) < 1 || count($data['checkEdgeSource']) < 1) {
            $data['msg'] = 'Buna bagli bir parent yoktur!';
            return $data;
        } else if (count($data['checkEdgeId']) > 0) {
            $data['msg'] = 'Bu baglantı zaten var!';
            return $data;
        } else {
            DB::table('edges')->insert([
                'id' => $req->edgeId,
                'source' => $req->edgeSource,
                'target' => $req->edgeTarget
            ]);

            $data['msg'] = 'Yeni child eklendi!';
            return $data;
        }
    });

    Route::get('/addstyle', function (Request $req) {
        $data['nodes'] =  DB::table('nodes')->get(['id']);
        $data['source'] =  DB::table('nodes')->groupBy('source')->get(['source']);
        return view('addstyle', $data);
    });

    Route::post('/getstyle', function (Request $req) {
        $data['nodes'] =  DB::table('nodes')->where('source', $req->source)->distinct()->get(['bg', 'bc', 'bw']);
        return  $data;
    });

    Route::post('/addstyle', function (Request $req) {
        if ($req->includeChild) {
            DB::table('nodes')->where('source', $req->basenode)->orWhere('id', $req->basenode)->update([
                'sh' => $req->sh,
                'bg' => $req->bg,
                'bw' => $req->bw,
                'bc' => $req->bc
            ]);
            DB::table('edges')->where('source', $req->basenode)->update(['bg' => $req->bg, 'arrowline' => $req->arrowLine]);
        } else {
            DB::table('nodes')->where('id', $req->basenode)->update([
                'sh' => $req->sh,
                'bg' => $req->bg,
                'bw' => $req->bw,
                'bc' => $req->bc
            ]);
            DB::table('edges')->where('target', $req->basenode)->where('source', $req->source)->update([
                'bg' => $req->bg
            ]);
        }
        return redirect('/addstyle');
    });

    Route::get('/nodes', function () {
        $data['nodes'] =  DB::table('nodes')->get();
        $data['edges'] =  DB::table('edges')->get();
        return view('nodes', $data);
    });

    Route::get('/edges', function () {
        $data['edges'] =  DB::table('edges')->get();
        return view('edges', $data);
    });

    Route::get('/nodedetails/{id}', function ($id) {
        $data['result'] =  DB::table('nodes')->where('source', $id)->orWhere('source2', $id)->orWhere('source3', $id)->orWhere('id', $id)->get(['id', 'type', 'text', 'location', 'address', 'link', 'category', 'bg']);
        return $data;
    });

    Route::post('/admin/removenode', function (Request $req) {
        if ($req->includeChild) {
            DB::table('edges')->where('source', $req->id)->delete();
            DB::table('nodes')->where('id', $req->id, 1)->orWhere('source', $req->id)->delete();
            $data['msg'] = 'Hepsi Silindi';
            return $data;
        } else {
            DB::table('nodes')->where('id', $req->id, 1)->delete();
            DB::table('edges')->where('target', $req->id, 1)->delete();
            $data['msg'] = 'Düğüm Silindi';
            return $data;
        }
    });
});

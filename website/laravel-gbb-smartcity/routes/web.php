<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\ProjectController;
use App\Http\Controllers\frontend\ActivitesController;

use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\backend\CategoriesController;
use App\Http\Controllers\backend\ActivitiesController;
use App\Http\Controllers\backend\ProjectsController;


Route::get('/', [HomeController::class,'Home'])->name('home');
Route::get('/getprojects', [ProjectController::class,'Projects']);
Route::get('/projectscategory/{category}', [ProjectController::class,'ProjectCategory']);
Route::get('/projectsdetails/{id}', [ProjectController::class,'ProjectDetails']);
Route::get('/activitiesdetails/{id}', [ActivitesController::class,'Activities']);


Route::get('/login',  [AuthController::class,'Login']);
Route::post('/login', [AuthController::class,'LoginPost']);

Route::delete('/logout', [AuthController::class,'Logout']);

Route::get('/resetpass', [AuthController::class,'ResetPassword']);
Route::post('/resetpass', [AuthController::class,'ResetPasswordPost']);


Route::middleware(['checkSession'])->group(function () {
    Route::resource('/admin/banner', BannerController::class);
    Route::resource('/admin/categories', CategoriesController::class);
    Route::resource('/admin/projects', ProjectsController::class);
    Route::resource('/admin/activities', ActivitiesController::class);

    //image
    Route::get('/admin/uploadimage', function(){
        return view('backend.pages.uploadimage');
    })->name('upload');
    
    Route::post('/admin/uploadimage/', function(Request $request){
       $fileName = $request->file->getClientOriginalName();
       $data['img'] = DB::table('images')->where('imgname', 'uploads/'.$request->maincategory.'/'.$request->subcategory.'/'.$fileName)->get();
        if(count($data['img']) > 0){
            return '401';
        }
        DB::table('images')->insert([
            'maincategory'=>$request->maincategory,
            'subcategory'=>$request->subcategory,
            'imgname'=>'uploads/'.$request->maincategory.'/'.$request->subcategory.'/'.$fileName
        ]);
        $request->file->move(public_path('uploads/'.$request->maincategory.'/'.$request->subcategory.'/'), $fileName);
        return $fileName;
    });
    
    Route::post('/admin/getsubcategory', function(Request $request){
        $data['result'] = DB::table($request->type)->orderBy('title')->get();
        return $data;
    });
    
    Route::post('/admin/getimages', function(Request $request){
        return $data['imgname'] = DB::table('images')->where('subcategory', $request->subcategory)->get(['imgname']);
    });
    
    Route::post('/admin/deleteimage', function(Request $request){
        DB::table('images')->where('imgname', $request->imgname, 1)->delete();
        File::delete($request->imgname);
        return '200';
    });

    Route::post('/admin/changecover', function(Request $request){
        DB::table($request->table)->where('title', $request->title, 1)->update(['img'=>$request->img]);
        return '200';
    });

});
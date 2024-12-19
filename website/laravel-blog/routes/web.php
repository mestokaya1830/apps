<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostAdminController;
use App\Http\Controllers\PostClientController;
use Illuminate\Support\Facades\Route;

//both middleware

Route::redirect('/', 'client');//use clients route instead /
Route::view('/about', 'client.about')->name('client.about');//use clients route instead /
Route::view('/contact', 'client.contact')->name('client.contact');//use clients route instead /
Route::resource('/client', PostClientController::class);
Route::get('/client/{user}/posts', [PostClientController::class,'clientUserPosts'])->name('client.user.posts');

//guest
Route::middleware(['guest'])->group(function(){
    Route::view('/register', 'client.register')->name('register');
    Route::view('/login', 'client.login')->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

//auth
Route::middleware(['auth'])->group(function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('/admin', PostAdminController::class);
});

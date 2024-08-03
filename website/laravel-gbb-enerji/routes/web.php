<?php

use App\Http\Controllers\backend\JoinerController;
use App\Http\Controllers\backend\QuestionsController;
use App\Http\Controllers\backend\QuizController;
use App\Http\Controllers\backend\UsersController;
use App\Http\Controllers\frontend\FrontendAboutusController;
use App\Http\Controllers\frontend\FrontendContactController;
use App\Http\Controllers\frontend\FrontendEmailController;
use App\Http\Controllers\frontend\FrontendIndexController;
use App\Http\Controllers\frontend\FrontendJoinerController;
use App\Http\Controllers\frontend\FrontendMainController;
use App\Http\Controllers\frontend\FrontendServicesController;
use App\Http\Controllers\frontend\FrontendSubjectsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.dashboard');

Route::get('/', [FrontendIndexController::class, 'index'])->name('index');
Route::get('/hakkimizda', [FrontendAboutusController::class, 'index'])->name('aboutus');
Route::get('/hizmetler', [FrontendServicesController::class, 'index'])->name('services');
Route::get('/iletisim', [FrontendContactController::class, 'index'])->name('contact');
Route::post('/iletisim/email', [FrontendEmailController::class, 'index'])->name('contact.email');
Route::post('/katilimci', [FrontendJoinerController::class, 'index'])->name('joiner');

Route::get('/konu1', [FrontendSubjectsController::class, 'subject1'])->name('subject1');
Route::get('/konu2', [FrontendSubjectsController::class, 'subject2'])->name('subject2');
Route::get('/konu3', [FrontendSubjectsController::class, 'subject3'])->name('subject3');
Route::get('/test', [FrontendMainController::class, 'index'])->name('test');
Route::get('/test/{id}', [FrontendMainController::class, 'questions'])->name('questions')->middleware('PreventBackHistory');
Route::get('/bitti', [FrontendMainController::class, 'finishTest'])->name('finish.test');

Route::get('/uyelik', [FrontendJoinerController::class, 'signupForm'])->name('joiner.signup.form');
Route::post('/uyelik', [FrontendJoinerController::class, 'signup'])->name('joiner.signup');
Route::get('/test/{joinerid}/{id}/sonuclar', [FrontendMainController::class, 'getResults'])->name('get-results');
Route::post('/test/{joinerid}/sonuclar', [FrontendMainController::class, 'setResults'])->name('set-results');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/admin/dashboard/users', UsersController::class);
    Route::resource('/admin/dashboard/quiz', QuizController::class);
    Route::resource('/admin/dashboard/quiz/{id}/questions', QuestionsController::class);

    Route::get('/admin/dashboard/joiners', [JoinerController::class, 'index'])->name('joiners.index');
    Route::get('/admin/dashboard/joiners/detail/{joinerid}/{quizid}', [JoinerController::class, 'details'])->name('joiners.details');
});

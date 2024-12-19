<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    public function Home()
    {
        $data['banner'] =  DB::table('banners')->get();
        $data['categories'] =  DB::table('categories')->get();
        $data['project'] =  DB::table('projects')->orderBy('id', 'desc')->take(6)->get();
        $data['activities'] =  DB::table('activities')->orderBy('id', 'desc')->get();
        return view('frontend.pages.home', $data);
    }
}

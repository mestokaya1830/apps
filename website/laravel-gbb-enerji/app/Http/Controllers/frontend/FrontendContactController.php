<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class FrontendContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }
}

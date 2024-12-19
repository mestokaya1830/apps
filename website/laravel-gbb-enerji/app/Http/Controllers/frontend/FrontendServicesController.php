<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class FrontendServicesController extends Controller
{
    public function index()
    {
        return view('frontend.services');
    }
}

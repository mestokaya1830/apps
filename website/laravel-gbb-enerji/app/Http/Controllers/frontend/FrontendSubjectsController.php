<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;

class FrontendSubjectsController extends Controller
{
    public function subject1()
    {
        return view('frontend.subjects.subject1');
    }

    public function subject2()
    {
        return view('frontend.subjects.subject2');
    }

    public function subject3()
    {
        return view('frontend.subjects.subject3');
    }
}

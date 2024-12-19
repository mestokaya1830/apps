<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\JoinedQuiz;
use App\Models\Joiners;
use Illuminate\Http\Request;

class JoinerController extends Controller
{
    public function index()
    {
        $joiners = Joiners::with('results')->get();

        return view('backend.joiners.index', compact('joiners'));
    }

    public function details(Request $request, $joinerId, $quizId)
    {
        $joinerDetails = JoinedQuiz::where('joiner_id', $joinerId)->where('quizes_id', $quizId)->get();

        return view('backend.joiners.details', compact('joinerDetails'));
    }
}

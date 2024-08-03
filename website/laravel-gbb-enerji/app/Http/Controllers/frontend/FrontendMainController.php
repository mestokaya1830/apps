<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Answers;
use App\Models\JoinedQuiz;
use App\Models\Quizes;
use App\Models\Results;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontendMainController extends Controller
{
    public function index()
    {
        $quizes = Quizes::where('state', 'aktif')->with(['allResults'])->get();

        return view('frontend.quiz', compact('quizes'));
    }

    public function questions(Request $request, $id)
    {
        if (session()->exists('joinerid')) {
            $checkResult = Results::where('joiner_id', session('joinerid'))->first();
            if (! $checkResult) {
                $source = Quizes::whereId($id)->with('questions')->first();
                $quizInfo = Quizes::whereId($id)->get();

                $quiz11 = $source->questions()->where('subject', 'Konu1')->where('level', 1)->inRandomOrder()->limit(1)->get();
                $quiz12 = $source->questions()->where('subject', 'Konu1')->where('level', 2)->inRandomOrder()->limit(2)->get();
                $quiz13 = $source->questions()->where('subject', 'Konu1')->where('level', 3)->inRandomOrder()->limit(2)->get();

                $quiz21 = $source->questions()->where('subject', 'Konu2')->where('level', 1)->inRandomOrder()->limit(1)->get();
                $quiz22 = $source->questions()->where('subject', 'Konu2')->where('level', 2)->inRandomOrder()->limit(2)->get();
                $quiz23 = $source->questions()->where('subject', 'Konu2')->where('level', 3)->inRandomOrder()->limit(2)->get();

                $quiz31 = $source->questions()->where('subject', 'Konu3')->where('level', 1)->inRandomOrder()->limit(2)->get();
                $quiz32 = $source->questions()->where('subject', 'Konu3')->where('level', 2)->inRandomOrder()->limit(2)->get();
                $quiz33 = $source->questions()->where('subject', 'Konu3')->where('level', 3)->inRandomOrder()->limit(2)->get();

                $questions = array_reduce([$quiz11, $quiz12, $quiz13, $quiz21, $quiz22, $quiz23, $quiz31, $quiz32, $quiz33], function ($arr, $item) {
                    if (empty($item) || $item->isEmpty()) {
                        return $arr;
                    }

                    return $arr->merge($item);
                }, $quiz11);
                $date = Carbon::now();
                $request->session()->put('startTime', $date->toDateTimeString());
                $request->session()->put('questions', $questions);

                return view('frontend.questions', compact('questions', 'quizInfo'));
            } else {
                return redirect()->route('get-results', [$id, session('joinerid')]);
            }
        } else {
            return redirect()->route('joiner.signup.form');
        }
    }

    public function setResults(Request $request)
    {
        $questions = session('questions');
        $correct = 0;
        $joinerId = session('id');
        $level1 = 0;
        $level2 = 0;
        $subject1_level3 = 0;
        $subject2_level3 = 0;
        $subject3_level3 = 0;
        foreach ($questions as $item) {
            Answers::create([
                'joiner_id' => $joinerId,
                'question_id' => $item->id,
                'answers' => $request->post($item->id),
            ]);
            if ($item->correct_answer === $request->post($item->id)) {
                $correct += 1;
                if ($item->level === '1') {
                    $level1 += 1;
                } elseif ($item->level === '2') {
                    $level2 += 1;
                } elseif ($item->subject === 'Konu1' && $item->level === '3') {
                    $subject1_level3 += 1;
                } elseif ($item->subject === 'Konu2' && $item->level === '3') {
                    $subject2_level3 += 1;
                } else {
                    $subject3_level3 += 1;
                }
            }
        }

        $score = (($level1 * 5) + ($level2 * 6) + ($subject1_level3 * 7) + ($subject2_level3 * 7) + ($subject3_level3 * 8));
        $wrong = count($questions) - $correct;

        $date = Carbon::now();
        $startTime = Carbon::parse($date);

        $finishTime = Carbon::parse(session('startTime'));

        $totalDuration = $finishTime->DiffInSeconds($startTime);

        Results::create([
            'joiner_id' => $joinerId,
            'quizes_id' => $item->quizes_id,
            'score' => $score,
            'correct_count' => $correct,
            'wrong_count' => $wrong,
            'start_time' => session('startTime'),
            'diff' => $totalDuration,
        ]);

        foreach ($questions as $item) {
            JoinedQuiz::create([
                'joiner_id' => $joinerId,
                'quizes_id' => $item->quizes_id,
                'question' => $item->question,
                'subject' => $item->subject,
                'level' => $item->level,
                'line' => $item->line,
                'A' => $item->A,
                'B' => $item->B,
                'C' => $item->C,
                'D' => $item->D,
                'correct_answer' => $item->correct_answer,
                'answers' => $request->post($item->id),
            ]);
        }

        return redirect()->route('finish.test');
    }

    public function finishTest()
    {
        if (session()->exists('joinerid')) {
            session()->forget('joinerid');
            session()->forget('name');

            return view('frontend.results');
        }
    }
}

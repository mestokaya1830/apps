<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionsCreateRequest;
use App\Http\Requests\QuestionsUpdateRequest;
use App\Models\Questions;
use App\Models\Quizes;

class QuestionsController extends Controller
{
    public function index($id)
    {
        $quiz = Quizes::whereId($id)->with('questions')->first() ?? abort('403', 'Soru Bulanamadı');

        return view('backend.questions.index', compact('quiz'));
    }

    public function create($id)
    {
        $quiz = Quizes::find($id);

        return view('backend.questions.create', compact('quiz'));
    }

    public function store(QuestionsCreateRequest $request, $id)
    {
        $checkQuestion = Questions::where('question', $request->question)->get();
        if (count($checkQuestion) > 0) {
            return redirect()->route('questions.create', $id)->withErrors('Bu Soru Sistemde Kayıtlıdır');
        } else {
            Quizes::find($id)->questions()->create($request->all());

            return redirect()->route('quiz.index')->withSuccess('Soru Başarıyla Oluşturuldu');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($quizId, $id)
    {
        $question = Quizes::find($quizId)->questions()->whereId($id)->first();

        return view('backend.questions.edit', compact('question'));
    }

    public function update(QuestionsUpdateRequest $request, $quizId, $id)
    {
        Quizes::find($quizId)->questions()->whereId($id)->first()->update($request->post());

        return redirect()->route('questions.index', [$quizId, $id])->withSuccess('Soru Başarıyla Güncellendi');
    }

    public function destroy($quizId, $id)
    {
        Quizes::find($quizId)->questions()->whereId($id)->delete();

        return redirect()->route('questions.index', $quizId)->withSuccess('Soru Başarıyla Silindi');
    }
}

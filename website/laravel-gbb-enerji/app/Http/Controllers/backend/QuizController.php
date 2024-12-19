<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuizCreateRequest;
use App\Http\Requests\QuizUpdateRequest;
use App\Models\Quizes;

class QuizController extends Controller
{
    public function index()
    {
        $quizes = Quizes::withCount('questions')->get();

        return view('backend.quizes.index', compact('quizes'));
    }

    public function create()
    {
        return view('backend.quizes.create');
    }

    public function store(QuizCreateRequest $request)
    {
        $checkQuiz = Quizes::where('title', $request->title)->get();
        if (count($checkQuiz) > 0) {
            return redirect()->route('quiz.index')->withErrors('Bu Konu Sistemde Kayıtlıdır!');
        } else {
            Quizes::create($request->post());

            return redirect()->route('quiz.index')->withSuccess('Konu Başarıyla Oluşturuldu');
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $quiz = Quizes::withCount('questions')->find($id) ?? abort('404', 'Konu Bulunamadı');

        return view('backend.quizes.edit', compact('quiz'));
    }

    public function update(QuizUpdateRequest $request, $id)
    {
        Quizes::where('id', $id)->update($request->except(['_method', '_token']));

        return redirect()->route('quiz.index')->withSuccess('Konu Başarıyla Güncellendi');
    }

    public function destroy($id)
    {
        Quizes::where('id', $id)->delete();

        return redirect()->route('quiz.index')->withSuccess('Konu Başarıyla Silindi');
    }
}

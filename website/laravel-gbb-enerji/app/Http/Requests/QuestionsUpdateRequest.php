<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionsUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'question' => 'required|min:5',
            'A' => 'required|min:1|max:255',
            'B' => 'required|min:1|max:255',
            'C' => 'required|min:1|max:255',
            'D' => 'required|min:1|max:255',
            'correct_answer' => 'required|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'question' => 'Soru',
            'A' => 'Cevap A',
            'B' => 'Cevap B',
            'C' => 'Cevap C',
            'D' => 'Cevap D',
            'correct_answer' => 'Doğru Cevap',
        ];
    }
}

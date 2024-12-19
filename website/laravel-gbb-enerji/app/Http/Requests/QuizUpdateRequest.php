<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuizUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|min:5|max:100',
            'description' => 'required|min:5',
            'state' => 'required',
            'finished_at' => 'after:'.now(),
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Başlık',
            'description' => 'Açıklama',
            'state' => 'Durum',
            'finished_at' => 'Bitiş Tarihi',
        ];
    }
}

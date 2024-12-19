<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinedQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'joiner_id',
        'quizes_id',
        'question',
        'subject',
        'level',
        'line',
        'A',
        'B',
        'C',
        'D',
        'correct_answer',
        'answers',
    ];
    // public function resultByUser(){
    //     return $this->hasOne('App\Models\Results')->where('joiner_id', session('joinerid'));
    // }
}

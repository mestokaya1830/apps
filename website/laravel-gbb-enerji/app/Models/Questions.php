<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'subject',
        'level',
        'line',
        'A',
        'B',
        'C',
        'D',
        'correct_answer',
    ];
}

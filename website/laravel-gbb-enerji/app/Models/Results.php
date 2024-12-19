<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Results extends Model
{
    use HasFactory;

    protected $fillable = [
        'joiner_id',
        'quizes_id',
        'correct_count',
        'wrong_count',
        'score',
        'start_time',
        'diff',
    ];
}

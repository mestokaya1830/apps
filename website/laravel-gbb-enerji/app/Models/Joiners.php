<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Joiners extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'phone',
        'identity',
    ];

    public function results()
    {
        return $this->hasMany(Results::class, 'joiner_id');
    }

    public function answers()
    {
        return $this->hasMany(Answers::class, 'joiner_id');
    }

    public function questions()
    {
        return $this->hasMany('App\Models\Questions');
    }
}

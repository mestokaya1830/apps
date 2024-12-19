<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quizes extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'state',
        'finiashes_at',
    ];

    protected $dates = ['finished_at']; //for diffForHumans

    public function questions()
    {
        return $this->hasMany('App\Models\Questions');
    }

    public function allResults()
    {
        return $this->hasMany('App\Models\Results');
    }

    protected $appends = ['details'];

    public function getDetailsAttribute()
    {
        if ($this->allResults()->count() > 0) {
            return [
                'avarage' => round($this->allResults()->avg('score')),
                'joiner_count' => $this->allResults()->count(),
            ];
        } else {
            return null;
        }
    }
}

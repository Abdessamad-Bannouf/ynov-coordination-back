<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuizzAnswer;
use App\Models\Tag;

class Quizz extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'question',
        'description',
        'category',
        'difficulty',
        'correct_answer',
        'explanation',
        'multiple_correct_answers',
        'correct_answers',
    ];

    protected $casts = [
        'multiple_correct_answers' => 'boolean',
        'answers' => 'array', // Pour stocker sous forme de JSON
        'correct_answers' => 'array', // Pour stocker sous forme de JSON
    ];

    public function answers()
    {
        return $this->hasMany(QuizzAnswer::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

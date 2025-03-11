<?php

namespace App\Models;

use App\Models\Quizz;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzCorrectAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quizz_id',
        'answer_key',
        'is_correct'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function quizz()
    {
        return $this->belongsTo(Quizz::class);
    }
}

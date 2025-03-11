<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizzAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quizz_id',
        'answer_key',
        'answer_text',
    ];
}

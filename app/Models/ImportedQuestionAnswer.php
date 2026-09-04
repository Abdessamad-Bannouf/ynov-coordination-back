<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedQuestionAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'imported_question_id',
        'external_id',
        'text',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(ImportedQuestion::class, 'imported_question_id');
    }
}

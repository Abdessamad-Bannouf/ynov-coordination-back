<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'external_id',
        'quiz_external_id',
        'quiz_title',
        'text',
        'type',
        'difficulty',
        'explanation',
        'category',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function answers()
    {
        return $this->hasMany(ImportedQuestionAnswer::class);
    }
}

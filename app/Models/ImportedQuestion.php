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
        'imported_category_id',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function answers()
    {
        return $this->hasMany(ImportedQuestionAnswer::class);
    }

    public function category()
    {
        return $this->belongsTo(ImportedCategory::class, 'imported_category_id');
    }
}

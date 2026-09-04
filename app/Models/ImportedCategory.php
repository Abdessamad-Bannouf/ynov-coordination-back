<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'name',
    ];

    public function questions()
    {
        return $this->hasMany(ImportedQuestion::class);
    }
}

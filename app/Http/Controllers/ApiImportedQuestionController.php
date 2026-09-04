<?php

namespace App\Http\Controllers;

use App\Models\ImportedQuestion;
use App\Services\QuizzService;

class ApiImportedQuestionController extends Controller
{
    protected $quizzService;

    public function __construct(QuizzService $quizzService)
    {
        $this->quizzService = $quizzService;
    }

    public function index()
    {
        return response()->json(ImportedQuestion::with('answers')->get());
    }

    public function import()
    {
        $questions = $this->quizzService->importQuestions();

        return response()->json(['imported' => $questions->count()]);
    }
}

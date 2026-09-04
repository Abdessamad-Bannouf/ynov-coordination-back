<?php

namespace App\Http\Controllers;

use App\Models\ImportedQuestion;
use App\Services\QuizzService;
use Illuminate\Http\Request;

class ApiImportedQuestionController extends Controller
{
    protected $quizzService;

    public function __construct(QuizzService $quizzService)
    {
        $this->quizzService = $quizzService;
    }

    public function index()
    {
        return response()->json(ImportedQuestion::with(['answers', 'category'])->get());
    }

    public function import(Request $request)
    {
        $questions = $this->quizzService->importQuestions($request->query('category'));

        return response()->json(['imported' => $questions->count()]);
    }
}

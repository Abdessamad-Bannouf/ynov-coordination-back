<?php

namespace App\Http\Controllers;

use App\Services\QuizzService;

class ApiQuizapiCategoryController extends Controller
{
    protected $quizzService;

    public function __construct(QuizzService $quizzService)
    {
        $this->quizzService = $quizzService;
    }

    public function index()
    {
        return response()->json($this->quizzService->getAvailableCategories());
    }
}

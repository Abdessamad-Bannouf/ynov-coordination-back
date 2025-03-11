<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizzService
{
    public function getquestions()
    {
        $response = Http::withHeaders([
            'X-Api-Key' => env('API_KEY'),
        ])->get('https://quizapi.io/api/v1/questions');

        return $response->json();
    }

    public function validatedRequest(Request $request)
    {
        return $request->validate([
            'question' => 'required|string',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'difficulty' => 'required|string|in:Easy,Medium,Hard',
            'correct_answer' => 'nullable|string',
            'explanation' => 'nullable|string',
            'multiple_correct_answers' => 'required|boolean',
            'answers' => 'required|array', // Bug qui me génère la page d'accueil de Laravel
            'correct_answers' => 'required|array', // Bug qui me génère la page d'accueil de Laravel
            'tags' => 'nullable|array',
        ]);
    }
}

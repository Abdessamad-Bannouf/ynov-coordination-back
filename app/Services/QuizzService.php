<?php

namespace App\Services;

use App\Models\ImportedCategory;
use App\Models\ImportedQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuizzService
{
    public function getquestions()
    {
        $response = Http::withToken(env('API_KEY'))
            ->get('https://quizapi.io/api/v1/questions');

        return $response->json();
    }

    /**
     * List the quiz categories quizapi.io actually supports for the
     * `category` filter on /questions (its top-level groups, e.g.
     * "Programming", "DevOps & Cloud" - not the ~145 finer-grained
     * sub-categories nested under them).
     *
     * @return \Illuminate\Support\Collection<int, array{name: string, quizCount: int}>
     */
    public function getAvailableCategories()
    {
        $response = Http::withToken(env('API_KEY'))
            ->get('https://quizapi.io/api/v1/categories');

        $payload = $response->json();

        if (!($payload['success'] ?? false)) {
            throw new \RuntimeException($payload['error'] ?? 'Failed to fetch categories from quizapi.io');
        }

        return collect($payload['data'] ?? [])->map(fn (array $group) => [
            'name' => $group['name'],
            'quizCount' => collect($group['categories'] ?? [])->sum('quizCount'),
        ]);
    }

    /**
     * Fetch questions from quizapi.io and persist them into imported_questions
     * (keyed on external_id, so re-running this updates existing rows instead
     * of duplicating them).
     *
     * @return \Illuminate\Support\Collection<int, ImportedQuestion>
     */
    public function importQuestions(?string $category = null)
    {
        $response = Http::withToken(env('API_KEY'))
            ->get('https://quizapi.io/api/v1/questions', array_filter([
                'category' => $category,
            ]));

        $payload = $response->json();

        if (!($payload['success'] ?? false)) {
            throw new \RuntimeException($payload['error'] ?? 'Failed to fetch questions from quizapi.io');
        }

        return collect($payload['data'] ?? [])->map(function (array $item) {
            $categoryId = null;
            if (!empty($item['category'])) {
                $categoryId = ImportedCategory::firstOrCreate(
                    ['source' => 'quizapi.io', 'name' => $item['category']]
                )->id;
            }

            $question = ImportedQuestion::updateOrCreate(
                ['external_id' => $item['id']],
                [
                    'source' => 'quizapi.io',
                    'quiz_external_id' => $item['quizId'] ?? null,
                    'quiz_title' => $item['quizTitle'] ?? null,
                    'text' => $item['text'],
                    'type' => $item['type'] ?? null,
                    'difficulty' => $item['difficulty'] ?? null,
                    'explanation' => $item['explanation'] ?? null,
                    'imported_category_id' => $categoryId,
                    'tags' => $item['tags'] ?? [],
                ]
            );

            foreach ($item['answers'] ?? [] as $answer) {
                $question->answers()->updateOrCreate(
                    ['external_id' => $answer['id']],
                    [
                        'text' => $answer['text'],
                        'is_correct' => $answer['isCorrect'] ?? false,
                    ]
                );
            }

            return $question;
        });
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

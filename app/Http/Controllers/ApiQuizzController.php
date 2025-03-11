<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use App\Models\QuizzAnswer;
use App\Models\QuizzCorrectAnswer;
use App\Models\Tag;
use App\Services\QuizzService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiQuizzController extends Controller
{
    protected $quizzService;

    public function __construct(QuizzService $quizzService)
    {
        $this->quizzService = $quizzService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions = $this->quizzService->getquestions();

        return response()->json($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Quizz
    {
        $validated = $this->quizzService->validatedRequest($request);

        $quizz = Quizz::create([
            'question' => $validated['question'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'difficulty' => $validated['difficulty'],
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'],
            'multiple_correct_answers' => $validated['multiple_correct_answers'],
        ]);

        $this->createAnswers($quizz->id, $validated);
        $this->createCorrectAnswers($quizz->id, $validated);
        $this->attachTags($quizz, $validated);

        return $quizz;
    }

    public function createAnswers(int $quizzId, $validated): void
    {
        foreach ($validated['answers'] as $key => $text) {
            if ($text) {
                QuizzAnswer::create([
                    'quizz_id' => $quizzId,
                    'answer_key' => $key,
                    'answer_text' => $text,
                ]);
            }
        }
    }

    public function createCorrectAnswers(int $quizzId, $validated): void
    {
        foreach ($validated['correct_answers'] as $key => $isCorrect) {
            QuizzCorrectAnswer::create([
                'quizz_id' => $quizzId,
                'answer_key' => $key,
                'is_correct' => $isCorrect === true ? true : false
            ]);
        }
    }

    public function attachTags(Quizz $quizz, $validated): void
    {
        if (!empty($validated['tags'])) {
            $tagIds = [];
            foreach ($validated['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $quizz->tags()->sync($tagIds);
        }

    }

    /**
     * Display the specified resource.
     */
    //public function show(Quizz $quizz)
    public function show(Quizz $quizz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Quizz $quizz, Request $request)
    {
        $validated = $this->quizzService->validatedRequest($request);

        $quizzz = Quizz::find($quizz->id);

        $quizzz->update([
            'question' => $validated['question'],
            'description' => $validated['description'],
            'category' => $validated['category'],
            'difficulty' => $validated['difficulty'],
            'correct_answer' => $validated['correct_answer'],
            'explanation' => $validated['explanation'],
            'multiple_correct_answers' => $validated['multiple_correct_answers'],
        ]);

        $this->createAnswers($quizz->id, $validated);
        $this->createCorrectAnswers($quizz->id, $validated);
        $this->attachTags($quizz, $validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quizz $quizz)
    {
        $quizz = Quizz::findOrFail($quizz->id);

        QuizzAnswer::where('quizz_id', $quizz->id)->delete();

        $quizz->tags()->detach();
        $quizz->delete();

        return response()->json(['message' => 'Quizz supprimé']);
    }
}

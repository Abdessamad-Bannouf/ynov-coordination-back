<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiQuizzController;
use App\Http\Controllers\ApiImportedQuestionController;
use App\Http\Controllers\ApiImportedCategoryController;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

Route::get('/api/csrf-token', function (Request $request) {
    return Response::json(['csrf_token' => csrf_token()]);
});

# ---------------------------------------------------------------------------------------------------------------------------------

// Quizz API

Route::post('/api/login', [ApiAuthController::class, 'loginWithFirebase'])->name('quizz.login');

Route::get('/api/quizz', [ApiQuizzController::class, 'index'])->name('quizz.get');

Route::post('/api/quizz', [ApiQuizzController::class, 'store'])->name('quizz.post');

Route::put('/api/quizz/{quizz}', [ApiQuizzController::class, 'update'])->name('quizz.update');

Route::delete('/api/quizz/{quizz}', [ApiQuizzController::class, 'destroy'])->name('quizz.destroy');




# ---------------------------------------------------------------------------------------------------------------------------------

// Category API

Route::get('/api/category', [\App\Http\Controllers\ApiCategoryController::class, 'index'])->name('category.get');

Route::post('/api/category', [\App\Http\Controllers\ApiCategoryController::class, 'store'])->name('category.post');

Route::put('/api/category/{category}', [\App\Http\Controllers\ApiCategoryController::class, 'update'])->name('category.update');

Route::delete('/api/category/{category}', [\App\Http\Controllers\ApiCategoryController::class, 'destroy'])->name('category.destroy');


# ---------------------------------------------------------------------------------------------------------------------------------

// Imported questions (quizapi.io)

Route::get('/api/imported-questions', [ApiImportedQuestionController::class, 'index'])->name('imported-questions.get');

Route::post('/api/imported-questions/import', [ApiImportedQuestionController::class, 'import'])->name('imported-questions.import');

Route::get('/api/imported-categories', [ApiImportedCategoryController::class, 'index'])->name('imported-categories.get');


Route::get('/', function () {
    return view('welcome');
});

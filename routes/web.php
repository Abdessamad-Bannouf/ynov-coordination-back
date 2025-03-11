<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiQuizzController;

Route::post('/api/login', [ApiAuthController::class, 'loginWithFirebase'])->name('quizz.update');;

Route::get('/api/quizz', [ApiQuizzController::class, 'index'])->name('quizz.get');

Route::post('/api/quizz', [ApiQuizzController::class, 'store'])->name('quizz.post');

Route::put('/api/quizz/{quizz}', [ApiQuizzController::class, 'update'])->name('quizz.update');

Route::delete('/api/quizz/{quizz}', [ApiQuizzController::class, 'delete'])->name('quizz.delete');

Route::get('/', function () {
    return view('welcome');
});

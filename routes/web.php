<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiQuizzController;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

Route::get('/api/csrf-token', function (Request $request) {
    return Response::json(['csrf_token' => csrf_token()]);
});

Route::post('/api/login', [ApiAuthController::class, 'loginWithFirebase'])->name('quizz.login');

Route::get('/api/quizz', [ApiQuizzController::class, 'index'])->name('quizz.get');

Route::post('/api/quizz', [ApiQuizzController::class, 'store'])->name('quizz.post');

Route::put('/api/quizz/{quizz}', [ApiQuizzController::class, 'update'])->name('quizz.update');

Route::delete('/api/quizz/{quizz}', [ApiQuizzController::class, 'destroy'])->name('quizz.destroy');

Route::get('/', function () {
    return view('welcome');
});

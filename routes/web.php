<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiQuizzController;

Route::middleware([\Illuminate\Http\Middleware\HandleCors::class])->post('/api/login', [ApiAuthController::class, 'loginWithFirebase'])->name('quizz.update');

Route::middleware([\Illuminate\Http\Middleware\HandleCors::class])->get('/api/quizz', [ApiQuizzController::class, 'index'])->name('quizz.get');

Route::middleware([\Illuminate\Http\Middleware\HandleCors::class])->post('/api/quizz', [ApiQuizzController::class, 'store'])->name('quizz.post');

Route::middleware([\Illuminate\Http\Middleware\HandleCors::class])->put('/api/quizz/{quizz}', [ApiQuizzController::class, 'update'])->name('quizz.update');

Route::middleware([\Illuminate\Http\Middleware\HandleCors::class])->delete('/api/quizz/{quizz}', [ApiQuizzController::class, 'delete'])->name('quizz.delete');

Route::get('/', function () {
    return view('welcome');
});

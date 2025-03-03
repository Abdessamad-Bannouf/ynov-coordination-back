<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;

Route::get('login', [ApiAuthController::class, 'loginWithFirebase']);

Route::get('/', function () {
    return view('welcome');
});

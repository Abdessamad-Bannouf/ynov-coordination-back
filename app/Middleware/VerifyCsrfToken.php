<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
    'api/*',  // Exempte toutes les routes API de la protection CSRF
    'users',  // Ajoute une exception pour cette route spécifique
    'sign-in'
    ];
}

<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;

class FirebaseAuthService
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount('../' . config('firebase.credentials'));
        $this->auth = $factory->createAuth();
    }

    public function verifyIdToken($idToken)
    {
        return $this->auth->verifyIdToken($idToken);
    }
}

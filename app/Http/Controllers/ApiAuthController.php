<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseAuthService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct(FirebaseAuthService $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    public function loginWithFirebase(Request $request)
    {
        $token = request()->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token is required'], 401);
        }

        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($token);
            $firebaseUserId = $verifiedIdToken->claims()->get('sub');

            $user = User::firstOrCreate(
                ['firebase_uid' => $firebaseUserId], // Condition pour trouver un utilisateur existant
                [
                    'email' => $verifiedIdToken->claims()->get('email'),
                    //'name' => $verifiedIdToken->claims()->get('name') ?? 'Firebase name',
                ]
            );

            Auth::login($user);

            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);        }
    }
}

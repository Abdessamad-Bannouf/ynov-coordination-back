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
        $validated = $request->validate([
            'idToken' => 'required|string',
        ]);

        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($request->idToken);
            $firebaseUserId = $verifiedIdToken->claims()->get('sub');

            $user = User::firstOrCreate(
                ['firebase_uid' => $firebaseUserId], // Condition pour trouver un utilisateur existant
                [
                    'email' => $verifiedIdToken->claims()->get('email'),
                    'name' => $verifiedIdToken->claims()->get('name') ?? 'Firebase name',
                ]
            );

            Auth::login($user);

            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);        }
    }
}

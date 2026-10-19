<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validation des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tentative d'authentification
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // Si vous utilisez Laravel Sanctum pour une API :
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Connexion réussie',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user
            ]);
        }

        // 3. Échec de l'authentification
        return response()->json([
            'message' => 'Identifiants invalides'
        ], 401);
    }
}
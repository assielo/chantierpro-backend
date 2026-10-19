<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // <-- Ajout du support des Logs
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. On écrit dans les logs ce que le frontend Flutter nous envoie
        Log::info('Donnees de connexion recues :', $request->all());

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'detail' => 'Identifiants incorrects'
            ], 400);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }
}
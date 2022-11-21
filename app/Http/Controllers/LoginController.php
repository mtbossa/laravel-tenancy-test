<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{

    public function authenticate(Request $request): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return response("", Response::HTTP_NO_CONTENT);
        }

        return response()->json([
            'email' => 'The provided credentials do not match our records.',
        ], Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response("", Response::HTTP_NO_CONTENT);
    }
}

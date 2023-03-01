<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) return response([
            "success" => false,
            "errors" => "Correo electronico o contraseña no válidos.\nIntentalo nuevamente"
        ], Response::HTTP_ACCEPTED);

        $user = User::where("email", $credentials["email"])->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            "success" => true,
            "token" => $token,
            "user" => $user
        ], Response::HTTP_ACCEPTED);
    }

    public function me()
    {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        return response([
            "success" => $request->user()->currentAccessToken()->delete()
        ]);
    }
}

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

    public function register(Request $request)
    {
       
    
        $request->validate([
            'name' => 'required',
            'last_names' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'updated_at' => 'required|date',
            'created_at' => 'required|date'
        ]);
    
        $user = new User();
        $user->name = $request->input('name');
        $user->last_names = $request->input('last_names');
        $user->email = $request->input('email');
        //$user->password = $request->input('password');
        $user->password = Hash::make($request->input('password'));
        $user->updated_at = now();
        $user->created_at = now();
        //$user->updated_at = $request->input('updated_at');
        //$user->created_at = $request->input('created_at');
        $user->save();
    
        $token = $user->createToken('auth_token')->plainTextToken;
        //return response()->json(['message' => 'User registered successfully'], 201);
        return response([
            "success" => true,
            "token" => $token,
            "user" => $user
        ], Response::HTTP_ACCEPTED);
    
    }
}

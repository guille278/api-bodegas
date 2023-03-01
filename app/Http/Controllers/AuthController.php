<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',


        ]);
        if ($validator->fails()) return back()->withErrors($validator->errors());

        $user = new User();

        $user->name = $request->name;
        $user->last_names = $request->last_names;
        $user->email= $request->email;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->identification = $request->identification;
        $user->rfc = $request->rfc;
        $user->phone = $request->phone;
        
        $user->save();

        Auth::login($user);
        return redirect()->to('/');
    }

    public function login(LoginRequest $request){

        $credentials = $request->validated();
        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ])) return back()
            ->withErrors(
                ['email' => 'El usuario y/o contraseña son incorrectos.']
            )->onlyInput('email');


        return view('/');
    }

    public function show()
    {
        return view('auth.register');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
}

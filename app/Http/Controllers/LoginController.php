<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        if (Auth::check()){
            return redirect()->route('panel');
        }
        return view('auth.index');
    }

    public function login(LoginRequest $request){
        if(!Auth::validate($request->only('email','password'))){
            return redirect()->to('login')->with('success', 'Credenciales incorrectas');
        }

        $user = Auth::getProvider()->retrieveByCredentials($request->only('email','password'));
        Auth::login($user);

        return redirect()->route('panel')->with('success', 'Bienvenido '.$user->name);
    }
}
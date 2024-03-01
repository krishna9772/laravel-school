<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){
        dd($request->all());
    }

    public function register(RegisterRequest $request){
        dd($request->all());
    }

    public function registerPage(){
        return view('auth.register');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){
            return redirect('/');
        } else {
            return back()->withErrors(['error' => 'The Credentials Do Not Match Our Records']);
        }
    }

    public function register(RegisterRequest $request){

        // $user_id = Str::random(8);

        // if (User::where('user_id', $user_id)->exists()) {
        //     $user_id = Str::random(8);
        // }

        $highestId = intval(User::max('user_id')) ?? 0;

        // Log::info("higheest id" . $highestId);

        // Increment the highest user ID and pad it with leading zeros
        $user_id = str_pad($highestId + 1, 5, '0', STR_PAD_LEFT);
        // Log::info($user_id);

        $user = User::create([
            'user_id' => $user_id,
            'user_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function registerPage(){
        return view('auth.register');
    }

    public function logout(){

        Auth::logout();

        return redirect('/');
    }

}

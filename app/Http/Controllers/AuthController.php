<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Models\UserGradeClass;

use function PHPUnit\Framework\returnValue;

class AuthController extends Controller
{
    public function loginPage(){
        return view('auth.login');
    }

    public function login(LoginRequest $request){

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials)){

            $userDetails = User::where('user_id',Auth::user()->user_id)->with('userGradeClasses')->get();

            return redirect('/');

        } else {
            return back()->withErrors(['error' => 'The Credentials Do Not Match Our Records']);
        }
    }

    public function register(RegisterRequest $request){

        $highestId = intval(User::max('user_id')) ?? 0;

        $user_id = str_pad($highestId + 1, 5, '0', STR_PAD_LEFT);

        $user = User::create([
            'user_id' => $user_id,
            'user_name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'admin'
        ]);

        $user->assignRole('admin');

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function registerPage(){
        return view('auth.register');
    }

    public function logout(){

        Auth::logout();

        return redirect()->route('loginPage');
    }

}

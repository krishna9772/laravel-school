<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $users = User::get();

        return view('testing',compact('users'));
    }

    public function testing(){
        $users = User::get();

        return view('testing',compact('users'));
    }
}

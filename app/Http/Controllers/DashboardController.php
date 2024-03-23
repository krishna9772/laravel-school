<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\ClassWork;
use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){

        // $users = User::get();

        if(Auth::check()){

            $studentCount = User::where('user_type','student')->count();

            $teacherCount = User::where('user_type','teacher')->count();

            $gradeCount = Grade::count();

            $classCount = Classes::count();

            $classworkCount = ClassWork::count();

            $curriculumCount = Curriculum::count();


            return view('dashboard',compact('studentCount','teacherCount','gradeCount','classCount','classworkCount','curriculumCount'));
        }

        return redirect()->route('login');

    }

}

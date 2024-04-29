<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Models\UserGradeClass;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PromoteRequest;
use Illuminate\Support\Facades\Session;

class PromoteController extends Controller
{

    public function searchGradeClass(){

        $user = Auth::user();

        if($user->hasRole('admin')){

            $grades = Grade::with('classes')->get();

            return view('promote.search',compact('grades'));
        }else{
            abort(403);
        }


    }

    public function searchResults(PromoteRequest $request){

        $user = Auth::user();

        if($user->hasRole('admin')){
            $students = User::select('users.*', 'user_grade_classes.grade_id',
                        'user_grade_classes.class_id', 'grades.grade_name',
                        'classes.class_name')
                    ->join('user_grade_classes', 'users.user_id', '=', 'user_grade_classes.user_id')
                    ->join('grades', 'user_grade_classes.grade_id', '=', 'grades.id')
                    ->join('classes', 'user_grade_classes.class_id', '=', 'classes.id')
                    ->where('users.user_type','student')
                    ->where('user_grade_classes.grade_id', $request->gradeSelect)
                    ->where('user_grade_classes.class_id', $request->classSelect)
                    ->where('users.user_type','student')
                    ->get();
                // dd($students->toArray());

            $grades = Grade::with('classes')->get();

            return view('promote.promote',compact('students','grades'));
        }else{
            abort(403);
        }



    }

    // promote student for class teacher

    public function promoteStudentForClassTeacher(){
        $user = Auth::user();

        if($user->hasRole('class teacher')){

            $userData = UserGradeClass::where('user_id',$user->user_id)->first();
            $grade_id = $userData->grade_id;
            $class_id = $userData->class_id;

            $students = User::select('users.*', 'user_grade_classes.grade_id',
            'user_grade_classes.class_id', 'grades.grade_name',
            'classes.class_name')
            ->join('user_grade_classes', 'users.user_id', '=', 'user_grade_classes.user_id')
            ->join('grades', 'user_grade_classes.grade_id', '=', 'grades.id')
            ->join('classes', 'user_grade_classes.class_id', '=', 'classes.id')
            ->where('users.user_type','student')
            ->where('user_grade_classes.grade_id', $grade_id)
            ->where('user_grade_classes.class_id', $class_id)
            ->where('users.user_type','student')
            ->get();
    // dd($students->toArray());

            $grades = Grade::with('classes')->get();

            return view('promote.promote',compact('students','grades'));

        }else{
            abort(403);
        }
    }


    public function promoteStudent(Request $request)
    {

        $user = Auth::user();

        if($user->hasRole('admin') || $user->hasRole('class teacher')){
            $selectedUserIds = $request->selected_students;

            foreach ($selectedUserIds as $userId) {

                UserGradeClass::where('user_id',$userId)->update([
                    'grade_id' => $request->gradeSelect,
                    'class_id' => $request->classSelect
                ]);
            }

            Session::put('message','Successfully promoted !');
            Session::put('alert-type','success');

            if($user->hasRole('admin')){
                return redirect()->route('promote.search');
            }

            if($user->hasRole('class teacher')){
                return redirect()->route('promote.student.class.teacher');
            }


        }else{
            abort(403);
        }


    }

}

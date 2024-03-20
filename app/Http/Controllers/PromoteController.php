<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoteRequest;
use App\Models\Grade;
use App\Models\User;
use App\Models\UserGradeClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PromoteController extends Controller
{

    public function searchGradeClass(){

        $grades = Grade::with('classes')->get();

        return view('promote.search',compact('grades'));
    }

    public function searchResults(PromoteRequest $request){

        $students = User::select('users.*', 'user_grade_classes.grade_id', 'user_grade_classes.class_id', 'grades.grade_name', 'classes.class_name')
                ->join('user_grade_classes', 'users.user_id', '=', 'user_grade_classes.user_id')
                ->join('grades', 'user_grade_classes.grade_id', '=', 'grades.id')
                ->join('classes', 'user_grade_classes.class_id', '=', 'classes.id')
                ->where('user_grade_classes.grade_id', $request->gradeSelect)
                ->where('user_grade_classes.class_id', $request->classSelect)
                ->get();

        $grades = Grade::with('classes')->get();

        return view('promote.promote',compact('students','grades'));

    }

    public function promoteStudent(Request $request)
    {

        $selectedUserIds = $request->selected_students;

        foreach ($selectedUserIds as $userId) {

            UserGradeClass::where('user_id',$userId)->update([
                'grade_id' => $request->gradeSelect,
                'class_id' => $request->classSelect
            ]);
        }

        return redirect()->route('promote.search');
    }

}

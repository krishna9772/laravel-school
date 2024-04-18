<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $grades = Grade::with('classes')->get();

        return view('grades.all_grades',compact('grades'));
    }


    public function showClasses($grade)
    {
        $grade = Grade::findOrFail($grade);
        $classes = $grade->classes;

        return view('grades.classes', compact('classes', 'grade'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('grades.new_grade');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GradeRequest $request)
    {
        Grade::create([
            'grade_name' => $request->name,
            'description' => $request->description,
            'created_date' => now(),
        ]);

        Session::put('message','Successfully added !');
        Session::put('alert-type','success');

        return response()->json('success');
    }

    public function modify(){

        $grades = Grade::get();

        return view('grades.update_delete',compact('grades'));
    }


    public function showRegistrations(string $gradeId, string $classId) {


        $users = User::whereIn('user_type', ['teacher', 'student'])
            ->whereHas('userGradeClasses', function ($query) use ($gradeId, $classId) {
                $query->where('grade_id', $gradeId)
                      ->where('class_id', $classId);
            })
            ->with(['userGradeClasses.grade', 'userGradeClasses.class'])
            ->get();

            $gradeName = Grade::where('id',$gradeId)->value('grade_name');
            $className = Classes::where('id',$classId)->value('class_name');
        // dd($users->toArray());

        return view('grades.show_registrations',compact('users','gradeName','className'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GradeRequest $request,string $id)
    {
        Grade::where('id',$id)->update([
            'grade_name' => $request->name,
            'description' => $request->description
        ]);

        Session::put('message','Successfully updated !');
        Session::put('alert-type','success');


        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Grade::where('id', $id)->delete();

            Session::put('message','Successfully deleted !');
            Session::put('alert-type','success');
    
            return response()->json('success');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the grade'], 500);
        }
    }
}

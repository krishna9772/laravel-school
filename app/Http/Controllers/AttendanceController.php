<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceSearchRequest;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $grades = Grade::with('classes')->get();

        return view('attendances.select_grade_class',compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function search(){

        $grades = Grade::all();

        return view('attendances.search_attendance',compact('grades'));

    }

    public function searchResults(AttendanceSearchRequest $request){
        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        // dd($gradeName);



        $students = User::where('user_type', 'student')
        ->whereHas('userGradeClasses', function ($query) use ($request) {
            $query->where('grade_id', $request->grade_select)
                ->where('class_id', $request->class_select);
        })
        ->get();

        // dd($studentList->toArray());

        return view('attendances.search_results',compact('gradeName','className','students'));
    }

    public function markAttendance(){

        $grades = Grade::with('classes')->get();

        return view('attendances.search_grade_class',compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

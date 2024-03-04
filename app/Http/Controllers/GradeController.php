<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\Grade;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $grades = Grade::with('classes')->get();
        // foreach($grades as $grade){
        //     echo $grade->classes->count();
        // }

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

        return response()->json('success');
    }

    public function modify(){

        $grades = Grade::get();

        return view('grades.update_delete',compact('grades'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $grades = Grade::get();

        // return view('grades.update_delete',compact('grades'));
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

        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Grade::where('id', $id)->delete();
            return response()->json('success');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the grade'], 500);
        }
    }
}

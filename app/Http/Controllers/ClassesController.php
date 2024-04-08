<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesRequest;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with('classes')->paginate(10);
        return view('classes.all_classes',compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createNewClass($gradeIdParameter = null)
    {

        $gradeName = Grade::where('id',$gradeIdParameter)->value('grade_name');

        $grades = Grade::get();

        return view('classes.new_class',compact('grades','gradeIdParameter','gradeName'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassesRequest $request)
    {

        Log::info($request->all());

        Classes::create([
            'grade_id' => $request->grade_id,
            'class_name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json('success');
    }

    public function modify(){

        $grades = Grade::with('classes')->get();

        return view('classes.update_delete',compact('grades'));
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
    public function update(ClassesRequest $request, string $id)
    {

        Classes::where('id',$id)->update([
            'grade_id' => $request->grade_id,
            'class_name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
             Classes::where('id', $id)->delete();
            return response()->json('success');
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while deleting the grade'], 500);
        }
    }
}

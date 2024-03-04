<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClassesRequest;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = Classes::with('grade')->get();
        return view('classes.all_classes',compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grades = Grade::get();

        return view('classes.new_class',compact('grades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClassesRequest $request)
    {
        Classes::create([
            'grade_id' => $request->grade_id,
            'class_name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json('success');
    }

    public function modify(){

        $grades = Grade::with('classes')->get();

        // foreach($grades as $grade){
        //     echo $grade->classes . '<br>';
        // }
        // dd($grades->classes);

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

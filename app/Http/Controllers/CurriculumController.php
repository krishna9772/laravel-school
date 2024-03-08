<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurriculumRequest;
use App\Models\Curriculum;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CurriculumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $curriculums = Curriculum::with('grade')->with('user')->get();

        $data = [];

        foreach ($curriculums as $curriculum) {

            $gradeId = $curriculum->grade->id;

            if (!isset($data[$gradeId])) {
                $data[$gradeId] = [
                    'grade' => $curriculum->grade,
                    'curriculums' => [],
                ];
            }

            $data[$gradeId]['curriculums'][] = [
                'curriculum' => $curriculum,
                'user' => $curriculum->user,
            ];
        }
        return view('curriculums.all_curriculums',compact('data'));
    }

    public function create()
    {
        $grades = Grade::all();

        $teachers = User::where('user_type','teacher')->get();

        return view('curriculums.new_curriculum',compact('grades','teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CurriculumRequest $request)
    {

        Log::info($request->all());
        Curriculum::create([
            'user_id' => $request->teacher_id,
            'grade_id' => $request->grade_id,
            'curriculum_name' => $request->curriculum_name,
        ]);

        return response()->json('success');
    }

    public function modify(){
        return view('curriculums.update_delete');
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
    public function update(CurriculumRequest $request, string $id)
    {
        Curriculum::where('id',$id)->update([
            'user_id' => $request->user_id,
            'grade_id' => $request->grade_id,
            'curriculum_name' => $request->curriculum_name,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Curriculum::where('id',$id)->delete();
        return response()->json('success');
    }
}

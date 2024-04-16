<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamMarkRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Classes;
use App\Models\ExamMark;
use App\Models\Grade;
use App\Models\User;
use App\Models\UserGradeClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ExamMarkController extends Controller
{
    public function addNewExamMark(){
        $grades = Grade::with('classes')->get();
        return view('exam_marks.search_exam_marks',compact('grades'));
    }

    public function searchResults(SearchRequest $request){

        // dd($request->all());

        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $students = User::where('user_type', 'student')
        ->whereHas('userGradeClasses', function ($query) use ($request) {
            $query->where('grade_id', $request->grade_select)
                ->where('class_id', $request->class_select);
        })
        ->with('userGradeClasses.examMarks')
        ->get();

        // dd($students->toArray());
        // dd($students[0]->userGradeClasses[0]->examMarks[0]->file);

        return view('exam_marks.new_exam_marks',compact('students','gradeName','className'));

    }

    public function store(Request $request){
        // dd($request->all());

        Log::info($request->all());

        $file = $request->file;

        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        $file->storeAs('public/exam_marks_files',$fileName);

        ExamMark::updateOrCreate([
            'user_grade_class_id' => $request->user_grade_class_id,
        ],[
            'file' => $fileName,
        ]);


        return response()->json('success');
    }


    public function edit(){
        $grades = Grade::with('classes')->get();
        // return view('exam_marks.update_delete',compact('grades'));

        return view('exam_marks.search_exam_marks',compact('grades'));
    }

    public function destroy($userGradeClassId){
        ExamMark::where('user_grade_class_id', $userGradeClassId)->delete();

        return 'delete success';
    }


    public function update(Request $request){

        Log::info($request->all());

        $file = $request->file;



        if($file != null || $file != ''){

            $userGradeClassId = UserGradeClass::where('grade_id',$request->grade_select)->where('class_id', $request->class_select)->pluck('id');

            Log::info("user grade class id " . $userGradeClassId);

            $oldImage = ExamMark::where('user_grade_class_id', $userGradeClassId)->pluck('file');

            Log::info("old file is " . $oldImage);

            Storage::delete('public/exam_marks_files/'. $oldImage);

            $fileName = uniqid() . '_' . $file->getClientOriginalName();

            $file->storeAs('public/exam_marks_files',$fileName);

            ExamMark::where('user_grade_class_id', $userGradeClassId)
                       ->update([
                            'file' => $fileName
                       ]);

            return response()->json('success');
        }
    }

}

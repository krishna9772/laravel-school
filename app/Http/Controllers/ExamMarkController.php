<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExamMarkRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Classes;
use App\Models\ExamMark;
use App\Models\Grade;
use App\Models\GradeSubjectExam;
use App\Models\User;
use App\Models\UserGradeClass;
use App\Models\SubjectMark;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Support\Facades\Input;
use Session;
use Auth;
use DB;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use PharIo\Manifest\Author;

class ExamMarkController extends Controller
{
    public function addNewExamMark(){

        $grades = Grade::with('classes')->get();
        return view('exam_marks.search_exam_marks',compact('grades'));
    }

    public function searchResults(SearchRequest $request){


        $user = Auth::user();

        if($user->hasRole('admin')){

            $gardeId = $request->grade_select;
            $classId = $request->class_select;

            $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');

            $grade = Grade::where('id',$request->grade_select)->with('examSubjects')->get();
            $gradeResult = $grade[0]->examSubjects;

            $className = Classes::where('id',$request->class_select)->value('class_name');

            $students = User::where('user_type', 'student')
            ->whereHas('userGradeClasses', function ($query) use ($request) {
                $query->where('grade_id', $request->grade_select)
                    ->where('class_id', $request->class_select);
            })
            ->with('userGradeClasses.examMarks')
            ->get();

        }

        elseif($user->hasRole('class teacher') || $user->hasRole('student')){


            $userData = UserGradeClass::where('user_id', $user->user_id)->first();

            $gradeId = $userData->grade_id;
            $classId = $userData->class_id;

            $gradeName = Grade::where('id',$gradeId)->value('grade_name');

            $grade = Grade::where('id',$gradeId)->with('examSubjects')->get();
            $gradeResult = $grade[0]->examSubjects;

            $className = Classes::where('id',$classId)->value('class_name');

            $students = User::where('user_type', 'student')->where('user_id',Auth::user()->id)
            ->whereHas('userGradeClasses', function ($query) use ($gradeId,$classId) {
                $query->where('grade_id', $gradeId)
                    ->where('class_id', $classId);
            })
            ->with('userGradeClasses.examMarks')
            ->get();

        }
        else{
            abort(403);
        }

        return view('exam_marks.new_exam_marks',compact('students','gradeName','className','gradeResult'));

    }


    public function classTeacherSearchResults(){
        $user = Auth::user();

        if($user->hasRole('class teacher')){
            $userData = UserGradeClass::where('user_id', $user->user_id)->first();

            $gradeId = $userData->grade_id;
            $classId = $userData->class_id;

            $gradeName = Grade::where('id',$gradeId)->value('grade_name');

            $grade = Grade::where('id',$gradeId)->with('examSubjects')->get();
            $gradeResult = $grade[0]->examSubjects;

            $className = Classes::where('id',$classId)->value('class_name');

            if(Auth::user()->user_type == 'student')
            {

                $students = User::where('user_type', 'student')->where('user_id',Auth::user()->id)
                ->whereHas('userGradeClasses', function ($query) use ($gradeId,$classId) {
                    $query->where('grade_id', $gradeId)
                        ->where('class_id', $classId);
                })
                ->with('userGradeClasses.examMarks')
                ->get();

            }else if(Auth::user()->user_type == 'teacher'){

                $students = User::where('user_type', 'student')
                ->whereHas('userGradeClasses', function ($query) use ($gradeId,$classId) {
                    $query->where('grade_id', $gradeId)
                        ->where('class_id', $classId);
                })
                ->with('userGradeClasses.examMarks')
                ->get();


            }
            

            return view('exam_marks.new_exam_marks',compact('students','gradeName','className','gradeResult'));

        }else{
            abort(403);
        }
    }


    public function store(ExamMarkRequest $request){

        Log::info($request->all());

        $file = $request->file;

        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        $file->storeAs('public/exam_marks_files',$fileName);
        

        ExamMark::updateOrCreate([
            'user_grade_class_id' => $request->user_grade_class_id,
        ],[
            'file' => $fileName,
        ]);


        Session::put('message','Successfully added !');
        Session::put('alert-type','success');

        return response()->json(['status' => 'success', 'fileName' => $fileName]);
    }


    public function edit(){

        $grades = Grade::with('classes')->get();

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

    public function allExamSubjects()
    {
        $grades = Grade::with('examSubjects')->paginate(10);
        return view('exam_marks.all_exam_subjects',compact('grades'));
    }

    public function getExamSubject()
    {
        $grades = Grade::all();

        $teachers = User::with('userGradeClasses')->where('user_type','teacher')->where('teacher_type','subject')->get();
        // dd($teachers->toArray());

        return view('exam_marks.create_subject',compact('grades','teachers'));
    }

    public function saveExamSubject(Request $request)
    {

        Log::info($request->all());


        $validator = \Illuminate\Support\Facades\Validator::make(['grade_id' => $request->grade_id],
        [
            'grade_id' => 'required',
        ]
        );
        $validator->validate();

        $subjects = $request->examSubject_name;

        foreach ($subjects as $index => $subjectName) {
            GradeSubjectExam::create([
                'grade_id' => $request->grade_id,
                'subject' => $subjectName,
            ]);
        }

        Session::put('message','Successfully added !');
        Session::put('alert-type','success');

        return response()->json('success');

    }


    public function showStudentExamMarks(){
        $user = Auth::user();

        if($user->hasRole('student')){
            $user_grade_class_id = UserGradeClass::where('user_id',$user->user_id)->pluck('id');

            $exam_marks = ExamMark::where('user_grade_class_id',$user_grade_class_id)->get();

        }else{
            abort(403);
        }
    }

}

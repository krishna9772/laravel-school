<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeTableRequest;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Timetable;
use App\Models\User;
use App\Models\UserGradeClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Time;

class TimetableController extends Controller
{

    // for admins and class teacher
    public function list(){

        $user = Auth::user();
        // dd($user->user_type);

        // if ($user->can('view') || $user->hasRole('class teacher')) {
        if($user->user_type == 'admin' || ($user->user_type == 'teacher' && $user->teacher_type == 'classroom')){
            // $timetables = Timetable::with(['grade', 'class'])->get();
            $timetables = Timetable::get();

        }elseif(($user->user_type == 'teacher' && $user->teacher_type == 'subject') || $user->user_type == 'student'){

            $teacher_id = Auth::user()->user_id;
            // dd($teacher_id);

            $teacherData = UserGradeClass::where('user_id',$teacher_id)->first();

            $timetables = Timetable::where('grade_id',$teacherData->grade_id)->where('class_id',$teacherData->class_id)->get();

        }else{
            abort(403, 'Unauthorized');
        }


        foreach($timetables as $timetable){
            $timetable->grade_name = Grade::where('id', $timetable->grade_id)->pluck('grade_name')->first();
            $timetable->class_name = Classes::where('id', $timetable->class_id)->pluck('class_name')->first();
        }


        return view('time_table.list',['timetables' => $timetables]);
    }

    // for subject teacher (can view only timetable)
    public function subjectTeacherViewTimeTable(){
        $teacher_id = Auth::user()->user_id;

        $teacherData = UserGradeClass::where('user_id',$teacher_id)->first();

        $timetable = Timetable::where('grade_id',$teacherData->grade_id)->where('class_id',$teacherData->class_id)->get();
        // dd($timetable->toArray());

        // return view('')
    }

    public function addNewTimeTable(){
        $grades = Grade::with('classes')->get();
        return view('time_table.new_time_table',compact('grades'));
    }


    public function store(TimeTableRequest $request){
        // dd($request->all());

        $file = $request->file;

        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        $file->storeAs('public/timetable_files',$fileName);

        Timetable::updateOrCreate([
            'grade_id' => $request->grade_select,
            'class_id' => $request->class_select,
        ],[
            'file' => $fileName,
        ]);

        return redirect()->route('timetables.list');

    }


    public function update(Request $request){

        Log::info($request->all());

        $file = $request->file;

        if($file != null || $file != ''){
            $oldFile = Timetable::where('grade_id', $request->grade_select)->where('class_id', $request->class_select)->pluck('file');

            Log::info("old file is " . $oldFile);

            Storage::delete('public/timetables_files/'.$oldFile);

            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            Log::info("file name is " . $fileName);

            $file->storeAs('public/timetable_files',$fileName);

            Timetable::where('grade_id', $request->grade_select)->where('class_id', $request->class_select)
                       ->update([
                            'file' => $fileName
                       ]);

            return response()->json('success');
        }
    }


    public function edit(){
        $grades = Grade::with('classes')->get();
        return view('time_table.edit',compact('grades'));
    }


    public function getTimetableFileName(Request $request){
        Log::info($request->all());

        $fileName = Timetable::where('grade_id',$request->grade_id)->where('class_id',$request->class_id)->pluck('file');

        Log::info($fileName);

        return response()->json($fileName);

    }


    public function destroy($gradeId, $classId){
        Timetable::where('grade_id', $gradeId)->where('class_id',$classId)->delete();

        return 'delete success';
    }



}

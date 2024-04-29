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
use Session;

use Ramsey\Uuid\Type\Time;

class TimetableController extends Controller
{

    public function list(){

        $user = Auth::user();
        // dd($user->user_type);

        if($user->hasRole('admin')){
            $timetables = Timetable::get();

        }elseif($user->hasRole('class teacher') || $user->hasRole('subject teacher') || $user->hasRole('student')){

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


    public function addNewTimeTable(){

        $user = Auth::user();

        if($user->hasRole('admin')){

            $grades = Grade::with('classes')->get();
            return view('time_table.new_time_table',compact('grades'));

        }elseif($user->hasRole('class teacher')){

            $grades = Grade::with('classes')->get();

            $userData = UserGradeClass::where('user_id',$user->user_id)->first();

            $gradeName = Grade::where('id',$userData->grade_id)->value('grade_name');
            $className = Classes::where('id',$userData->class_id)->value('class_name');

            return view('time_table.new_time_table',compact('grades','userData','gradeName','className'));

        }else{
            abort(403);
        }


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

        Session::put('message','Successfully added !');
        Session::put('alert-type','success');

        return redirect()->route('timetables.list');

    }


    public function update(Request $request){

        $user = Auth::user();

        if($user->hasRole('admin') || $user()->hasRole('class teacher')){
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

                Session::put('message','Successfully updated !');
                Session::put('alert-type','success');

                if($user->hasRole('admin')){
                    return response()->json('success');
                }

                if($user->hasRole('class teacher')){
                    return redirect()->route('timetables.list');
                }


            }
        }else{
            abort(403);
        }


    }


    public function edit(){

        $user = Auth::user();

        if($user->hasRole('admin')){

            $grades = Grade::with('classes')->get();
            return view('time_table.edit',compact('grades'));

        }elseif($user->hasRole('class teacher')){

            $grades = Grade::with('classes')->get();

            $userData = UserGradeClass::where('user_id',$user->user_id)->first();

            $gradeName = Grade::where('id',$userData->grade_id)->value('grade_name');
            $className = Classes::where('id',$userData->class_id)->value('class_name');

            return view('time_table.edit',compact('grades','userData','gradeName','className'));

        }else{
            abort(403);
        }


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

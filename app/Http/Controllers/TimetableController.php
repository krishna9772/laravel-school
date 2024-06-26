<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeTableRequest;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Time;

class TimetableController extends Controller
{

    public function list(){

        $timetables = Timetable::get();
        // $timetable = [];

        foreach($timetables as $timetable){
            $timetable->grade_name = Grade::where('id', $timetable->grade_id)->pluck('grade_name')->first();
            $timetable->class_name = Classes::where('id', $timetable->class_id)->pluck('class_name')->first();
        }


        return view('time_table.list',['timetables' => $timetables]);
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

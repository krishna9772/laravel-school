<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AcadamicYearController extends Controller
{
    public function index(){

        $academicYears = AcademicYear::get();
        // dd($academicYear->toArray());

        return view('academic_year.academic_years',compact('academicYears'));
    }

    public function getCalendarInfo($id){
        $selectedAcademicYear = AcademicYear::where('id',$id)->first();

        return response()->json($selectedAcademicYear);
    }

    public function store(AcademicYearRequest $request){
        // dd($request->all());

        // AcademicYear::updateOrCreate([
        //         'id' => $request->academic_id
        //     ],[
        //         'academic_year' => $request->academic_year,
        //         'start_date' => $request->start_date,
        //         'end_date' => $request->end_date
        // ]);

        AcademicYear::create([
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        // return redirect()->route('academic-years.index');
        return response()->json('success');

    }

    public function update(AcademicYearRequest $request){

        Log::info($request->all());

        AcademicYear::where('id',$request->id)->update([
            'academic_year' => $request->academic_year,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        return response()->json('success');
    }

    public function destroy($id){

        AcademicYear::where('id',$id)->delete();

        return response()->json('success');

    }


}

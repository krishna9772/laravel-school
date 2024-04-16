<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcademicYearRequest;
use App\Models\AcademicYear;
use Illuminate\Http\Request;

class AcadamicYearController extends Controller
{
    public function index(){

        $academicYear = AcademicYear::first();
        // dd($academicYear->toArray());

        return view('academic_year.new_academic_year',compact('academicYear'));
    }

    public function store(AcademicYearRequest $request){
        // dd($request->all());

        AcademicYear::updateOrCreate([
                'id' => $request->academic_id
            ],[
                'academic_year' => $request->academic_year,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date
        ]);

        return redirect()->route('academic-years.index');

    }

}

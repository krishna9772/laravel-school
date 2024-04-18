<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayRequest;
use App\Models\AcademicYear;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{
    public function index(){

        $academicYear = AcademicYear::first();

        $academicYears = AcademicYear::get();

        return view('academic_year.holidays',compact('academicYears'));
    }

    public function store(HolidayRequest $request){
        Log::info($request->all());

        $academic_id = $request->academic_id;
        $names = $request->name;
        $dates = $request->date;

        foreach($names as $index => $name){
            Holiday::create([
                'academic_id' => $academic_id,
                'name' => $name,
                'date' => $dates[$index],
            ]);
        }




    }

}

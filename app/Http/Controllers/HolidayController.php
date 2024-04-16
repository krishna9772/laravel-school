<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HolidayController extends Controller
{
    public function index(){

        $academicYear = AcademicYear::first();

        return view('academic_year.holidays',compact('academicYear'));
    }

    public function store(Request $request){
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

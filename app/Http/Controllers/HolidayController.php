<?php

namespace App\Http\Controllers;

use App\Http\Requests\HolidayRequest;
use App\Models\AcademicYear;
use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HolidayController extends Controller
{
    public function index(){

        // $academicYear = AcademicYear::first();

        $academicYears = AcademicYear::get();

        $holidays = Holiday::get();

        return view('academic_year.holidays',compact('academicYears','holidays'));
    }

    // public function store(HolidayRequest $request){
    //     Log::info($request->all());

    //     $academic_id = $request->academic_id;
    //     $names = $request->name;
    //     $dates = $request->date;
    //     $holiday_ids = $request->holiday_id;

    //     foreach($names as $index => $name){
    //         if(isset($holiday_ids[$index])) {
    //             Holiday::where('id', $holiday_ids[$index])->update([
    //                 'name' => $name,
    //                 'date' => $dates[$index],
    //             ]);
    //         } else {
    //             Holiday::create([
    //                 'academic_id' => $academic_id,
    //                 'name' => $name,
    //                 'date' => $dates[$index],
    //             ]);
    //         }
    //     }

    //     Session::put('message','Successfully added !');
    //     Session::put('alert-type','success');

    //     return response()->json('success');

    // }

    public function store(HolidayRequest $request){
        Log::info($request->all());

        $academic_id = $request->academic_id;
        $name = $request->name;
        $date = $request->date;

        Holiday::create([
            'academic_id' => $academic_id,
            'name' => $name,
            'date' => $date,
        ]);

        return response()->json('success');

    }

    public function update(HolidayRequest $request){
        Log::info($request->all());

        Holiday::where('id',$request->id)->where('academic_id',$request->academic_id)
               ->update([
                    'name' => $request->name,
                    'date' => $request->date,
               ]);

        return response()->json('success');
    }

    public function destroy($id){


        Log::info("id is " . $id);

        Holiday::where('id',$id)->delete();

        return response()->json('success');

    }

}

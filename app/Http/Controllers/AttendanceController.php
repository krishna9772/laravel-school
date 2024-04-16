<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttendanceSearchRequest;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Grade;
use App\Models\Holiday;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $grades = Grade::with('classes')->get();

        // return view('attendances.select_grade_class',compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function search(){

        $grades = Grade::all();

        return view('attendances.search_attendance',compact('grades'));

    }

    public function searchResults(AttendanceSearchRequest $request){


        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $gradeId = $request->grade_select;
        $classId = $request->class_select;

        // dd($gradeName);

        $students = User::where('user_type', 'student')
        ->whereHas('userGradeClasses', function ($query) use ($request) {
            $query->where('grade_id', $request->grade_select)
                ->where('class_id', $request->class_select);
        })
        ->with('userGradeClasses.attendances')
        ->get();

        $startDate = AcademicYear::first()->start_date;
        $endDate = AcademicYear::first()->end_date;

        // foreach($students as $student){
        //     $status = $student->userGradeClasses[0]->attendances[0]->status;
        //     dd($status);
        // }
        // dd($status);

        // dd($students->toArray());

        $holidays = Holiday::select('date')->get();
        // dd($holidays->toArray());

        $todayDate = Carbon::now()->toDateString();
        // dd($todayDate);

        $attendances = Attendance::get();

        // dd($students);
        // dd($students[1]->userGradeClasses);
        // dd($students[0]->userGradeClasses[0]->grade_id);

        return view('attendances.mark_attendance',compact('gradeName','className','students','todayDate','attendances','gradeId','classId','startDate','endDate','holidays'));
    }

    public function viewReport(AttendanceSearchRequest $request){
        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $thisMonth = date('n');

        // $thisMonth = Carbon::now()->month();
        // dd($thisMonth);

        // $now = Carbon::now();
        // $month = $now->format('m');
        // dd($month);

        $students = User::where('user_type', 'student')
            ->whereHas('userGradeClasses', function ($query) use ($request) {
                $query->where('grade_id', $request->grade_select)
                    ->where('class_id', $request->class_select);
            })
            ->with(['userGradeClasses.attendances' => function ($query) {
                $query->whereMonth('created_at', Carbon::now()->month);
            }])
            ->get();

        foreach ($students as $student) {
            $totalAttendanceCount = 0;
            $presentCount = 0;

            foreach ($student->userGradeClasses as $userGradeClass) {
                $totalAttendanceCount += $userGradeClass->attendances->count();
                $presentCount += $userGradeClass->attendances->where('status', 'present')->count();
            }

            $student->percentage = $totalAttendanceCount > 0 ? ($presentCount / $totalAttendanceCount) * 100 : 0;
        }

        $todayDate = Carbon::today();
        // dd($todayDate);

        $gradeSelectedId = $request->grade_select;
        $classSelectedId = $request->class_select;

        return view('attendances.attendance_report', compact('gradeName','todayDate', 'className', 'students','thisMonth','gradeSelectedId','classSelectedId'));
    }


    public function percentagePerMonth(Request $request, $month){

        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $students = User::where('user_type', 'student')
            ->whereHas('userGradeClasses', function ($query) use ($request) {
                $query->where('grade_id', $request->grade_select)
                    ->where('class_id', $request->class_select);
            })
            ->with(['userGradeClasses.attendances' => function ($query) use ($month) {
                $query->whereMonth('created_at', $month);
            }])
            ->get();

        foreach ($students as $student) {
            $totalAttendanceCount = 0;
            $presentCount = 0;

            foreach ($student->userGradeClasses as $userGradeClass) {
                $totalAttendanceCount += $userGradeClass->attendances->count();
                $presentCount += $userGradeClass->attendances->where('status', 'present')->count();
            }

            $student->percentage = $totalAttendanceCount > 0 ? ($presentCount / $totalAttendanceCount) * 100 : 0;
        }

        $thisMonth = Carbon::now()->month();

        return response()->json($students);

        // return response()->json($gradeName,$className,$students,$thisMonth);

        // return view('attendances.attendance_report', compact('gradeName', 'className', 'students','thisMonth'));
    }

    public function attendanceDetails(Request $request){

        //percentage per month

        $month = $request->month;

        $student = User::where('user_id', $request->user_id)
            ->with(['userGradeClasses.attendances' => function ($query) use ($month) {
                $query->whereMonth('attendance_date', $month);
            }])
            ->get();

            $totalAttendanceCount = 0;
            $presentCount = 0;

            foreach ($student[0]->userGradeClasses as $userGradeClass) {
                $totalAttendanceCount += $userGradeClass->attendances->count();
                $presentCount += $userGradeClass->attendances->where('status', 'present')->count();
            }

            $student->percentage = $totalAttendanceCount > 0 ? ($presentCount / $totalAttendanceCount) * 100 : 0;


            Log::info("percentage is " .  $student->percentage);


        // Log::info($request->all());

        $studentName = User::where('user_id',$request->user_id)->pluck('user_name');

        // $month = $request->month;

        // $percentage = $request->percentage;

        // Log::info($percentage);

        $dateString = date('Y-m-d', strtotime("2024-$month-01"));

        $monthName = date('F', strtotime($dateString));

        $startDate = Carbon::createFromFormat('Y-m-d', date('Y-' . $month . '-01'));
        $endDate = $startDate->copy()->endOfMonth();


        $attendanceDetails = User::where('user_id', $request->user_id)
            ->with(['userGradeClasses.attendances' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('attendance_date', [$startDate, $endDate]);
            }])
            ->first();

        $attendanceStatus = [];
        $dayOfWeek = [];


        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $dateString = $currentDate->toDateString();

            $dayOfWeekString = $currentDate->format('l');


            $attendanceRecord = $attendanceDetails->userGradeClasses[0]->attendances
                ->where('attendance_date', $dateString)
                ->first();

            $status = $attendanceRecord ? $attendanceRecord->status : 'absent';

            $attendanceStatus[$dateString] = $status;
            $dayOfWeek[$dateString] = $dayOfWeekString;

            $currentDate->addDay();
        }

        // Log::info($attendanceStatus,$monthName);

        Log::info($dayOfWeek);


        return response()->json([
            'studentName' => $studentName,
            'attendanceStatus' => $attendanceStatus,
            'dayOfWeek' => $dayOfWeek,
            'monthName' => $monthName,
            'percentage' => $student->percentage
        ]);

    }


    public function attendanceByDate(Request $request){
        Log::info($request->all());

        $selectedDate = $request->selected_date;

        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $students = User::where('user_type', 'student')
            ->whereHas('userGradeClasses', function ($query) use ($request) {
                $query->where('grade_id', $request->grade_select)
                    ->where('class_id', $request->class_select);
            })
            ->with(['userGradeClasses.attendances' => function ($query) use ($selectedDate) {
                $query->whereDate('created_at', $selectedDate);
            }])
            ->get();

        foreach ($students as $student) {
            $totalAttendanceCount = 0;
            $presentCount = 0;

            foreach ($student->userGradeClasses as $userGradeClass) {
                $totalAttendanceCount += $userGradeClass->attendances->count();
                $presentCount += $userGradeClass->attendances->where('status', 'present')->count();
            }

            $student->percentage = $totalAttendanceCount > 0 ? ($presentCount / $totalAttendanceCount) * 100 : 0;
        }

        Log::info($students);

        $thisMonth = Carbon::now()->month();

        return response()->json($students);
    }



    public function markAttendance(){

        $grades = Grade::with('classes')->get();

        return view('attendances.search_grade_class',compact('grades'));
    }

    public function attendanceByDateInMarkAttendance(Request $request){
        Log::info($request->all());

        $selectedDate = $request->selected_date;

        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $students = User::where('user_type', 'student')
            ->whereHas('userGradeClasses', function ($query) use ($request) {
                $query->where('grade_id', $request->grade_select)
                    ->where('class_id', $request->class_select);
            })
            ->with(['userGradeClasses.attendances' => function ($query) use ($selectedDate) {
                $query->whereDate('attendance_date', $selectedDate);
            }])
            ->get();

        Log::info($students);

        // $thisMonth = Carbon::now()->month();

        return response()->json($students);

    }

    // public function viewReport(){
    //     $gr
    // }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // dd($request->all());

    //     Log::info($request->all());

    //     $studentIds = $request->student_id;
    //     $userGradeClassIds = $request->user_grade_class_id;
    //     $statuses = $request->status;
    //     $reasons = $request->reason;

    //     foreach ($studentIds as $index => $studentId) {
    //         $attendance = new Attendance;
    //         $attendance->user_grade_class_id = $userGradeClassIds[$index];
    //         $attendance->status = $statuses[$studentId];
    //         $attendance->reason = $reasons[$index] ?? null;
    //         $attendance->save();
    //     }

    //     return response()->json('success');
    // }


    public function store(Request $request)
    {
        // dd($request->all());

        Log::info($request->all());

        $reason = $request->reason;

        if($reason !== null){
            Attendance::updateOrCreate([
                'user_grade_class_id' => $request->user_grade_class_id,
                'attendance_date' => $request->selectedDate,

            ],[
                'reason' => $request->reason,
            ]);
        }else{
            Attendance::updateOrCreate([
                'user_grade_class_id' => $request->user_grade_class_id,
                'attendance_date' => $request->selectedDate,

            ],[
                'status' => $request->status,
            ]);
        }




        return response()->json('success');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

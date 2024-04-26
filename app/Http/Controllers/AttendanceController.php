<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Grade;
use App\Models\Classes;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\AttendanceSearchRequest;

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

        $dateToShow = Carbon::now();

        if ($dateToShow->isWeekend()) {
            $dateToShow = $dateToShow->previous(Carbon::FRIDAY);
        }

        $holidays = Holiday::pluck('date')->toArray();

        while ($dateToShow->isWeekend() || in_array($dateToShow->toDateString(), $holidays)) {
            $dateToShow->subDay();
        }

        $dateToShow = $dateToShow->toDateString();

        // dd($dateToShow);

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
        ->with(['userGradeClasses.attendances' => function ($query) use ($dateToShow) {
            $query->whereDate('attendance_date', $dateToShow);
        }])
        ->get();

        if(AcademicYear::first() == '')
        {
            return redirect()->route('academic-years.index')->with("message","Please fill academic settings first")->with("alert-type","warning");
        }

        $startDate = AcademicYear::first()->start_date;

        $endDate = AcademicYear::first()->end_date;

        $holidays = Holiday::select('date')->get();

        // $dateToShow = Carbon::now()->toDateString();

        $attendances = Attendance::get();

        return view('attendances.mark_attendance',compact('gradeName','className','students','dateToShow','attendances','gradeId','classId','startDate','endDate','holidays'));
    }

    public function viewReport(AttendanceSearchRequest $request){

        if(AcademicYear::first() == '')
        {
            return redirect()->route('academic-years.index')->with("message","Please fill academic settings first")->with("alert-type","warning");
        }

        $gradeName = Grade::where('id',$request->grade_select)->value('grade_name');
        $className = Classes::where('id',$request->class_select)->value('class_name');

        $thisMonth = date('n');

        $year = date('Y');

        $academic_year = AcademicYear::where('academic_year', '=', $year)->first();

        $toDate = Carbon::parse($academic_year->start_date);
        $fromDate = Carbon::parse($academic_year->end_date);
  
        $days = $toDate->diffInDays($fromDate);  

        // return $days;

        // for monthly show
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

            $student->percentage = $totalAttendanceCount > 0 ? ($presentCount / Carbon::now()->month($thisMonth)->daysInMonth) * 100 : 0;
        }

        $dateToShow = Carbon::now();

        if ($dateToShow->isWeekend()) {
            $dateToShow = $dateToShow->previous(Carbon::FRIDAY);
        }

        $holidays = Holiday::pluck('date')->toArray();

        while ($dateToShow->isWeekend() || in_array($dateToShow->toDateString(), $holidays)) {
            $dateToShow->subDay();
        }

        $dateToShow = $dateToShow->toDateString();

        // students daily status

        $studentsDaily = User::where('user_type', 'student')
        ->whereHas('userGradeClasses', function ($query) use ($request) {
            $query->where('grade_id', $request->grade_select)
                ->where('class_id', $request->class_select);
        })
        ->with(['userGradeClasses.attendances' => function ($query) use ($dateToShow) {
            $query->whereDate('attendance_date', $dateToShow);
        }])
        ->get();


        // $todayDate = Carbon::today();

        $gradeSelectedId = $request->grade_select;
        $classSelectedId = $request->class_select;

        $startDate = AcademicYear::first()->start_date;
        $endDate = AcademicYear::first()->end_date;
        // dd($endDate);


        $holidays = Holiday::select('date')->get();

        return view('attendances.attendance_report', compact('gradeName','dateToShow', 'className', 'students','studentsDaily','thisMonth','gradeSelectedId','classSelectedId','startDate','endDate','holidays'));
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

    // public function attendanceDetails(Request $request){

    //     // Get the month and user_id from the request
    //     $month = $request->month;
    //     $user_id = $request->user_id;

    //     // Fetch user details
    //     $student = User::where('user_id', $user_id)
    //         ->with(['userGradeClasses.attendances' => function ($query) use ($month) {
    //             $query->whereMonth('attendance_date', $month);
    //         }])
    //         ->first();

    //     // Calculate total days in the month, excluding weekends and holidays
    //     $startDate = Carbon::createFromDate(date('Y'), $month, 1)->startOfMonth();
    //     $endDate = $startDate->copy()->endOfMonth();
    //     $totalDays = $startDate->diffInDaysFiltered(function($date) {
    //         return !$date->isWeekend() && !Holiday::where('date', $date)->exists();
    //     }, $endDate) + 1;

    //     // Calculate attendance
    //     $presentCount = 0;
    //     foreach ($student->userGradeClasses as $userGradeClass) {
    //         foreach ($userGradeClass->attendances as $attendance) {
    //             if (!$attendance->attendance_date->isWeekend() && !Holiday::where('date', $attendance->attendance_date)->exists()) {
    //                 if ($attendance->status === 'present') {
    //                     $presentCount++;
    //                 }
    //             }
    //         }
    //     }

    //     // Calculate percentage
    //     $percentage = $totalDays > 0 ? ($presentCount / $totalDays) * 100 : 0;

    //     // Prepare response
    //     $studentName = $student->user_name;
    //     $monthName = $startDate->format('F');

    //     $attendanceStatus = [];
    //     $dayOfWeek = [];

    //     $currentDate = $startDate->copy();
    //     while ($currentDate->lte($endDate)) {
    //         $dateString = $currentDate->toDateString();
    //         $dayOfWeekString = $currentDate->format('l');
    //         $attendanceRecord = $student->userGradeClasses->flatMap->attendances->where('attendance_date', $dateString)->first();
    //         $status = $attendanceRecord ? $attendanceRecord->status : '-';
    //         $attendanceStatus[$dateString] = $status;
    //         $dayOfWeek[$dateString] = $dayOfWeekString;
    //         $currentDate->addDay();
    //     }

    //     return response()->json([
    //         'studentName' => $studentName,
    //         'attendanceStatus' => $attendanceStatus,
    //         'dayOfWeek' => $dayOfWeek,
    //         'monthName' => $monthName,
    //         'percentage' => $percentage
    //     ]);
    // }


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

        $holidays = Holiday::select('date')->get();

        $weekends =

        Log::info("holdiays " . $holidays);


          $startDate = Carbon::createFromFormat('Y-m-d', date('Y-' . $request->month . '-01'));
          $endDate = $startDate->copy()->endOfMonth();

          $weekends = ['Sunday','Saturday'];

        //   while($currentDate)

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

          Log::info( $weekends);


          if (!$holidays->contains('date', $dateString)) {

              if (!in_array($dayOfWeekString, $weekends)) {

                  $attendanceRecord = $attendanceDetails->userGradeClasses[0]->attendances
                      ->where('attendance_date', $dateString)
                      ->first();

                  $status = $attendanceRecord ? $attendanceRecord->status : '-';
                  $attendanceStatus[$dateString] = $status;

                  $dayOfWeek[$dateString] = $dayOfWeekString;
              }
          }

          $currentDate->addDay();
      }

        Log::info($dayOfWeek);

        $filteredDayOfWeek = array_filter($dayOfWeek, function ($day) use ($weekends) {
            return !in_array($day, $weekends);
          });

          Log::info($filteredDayOfWeek);


        return response()->json([
            'studentName' => $studentName,
            'attendanceStatus' => $attendanceStatus,
            'dayOfWeek' => $filteredDayOfWeek,
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
                $query->whereDate('attendance_date', $selectedDate);
            }])
            ->get();

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

        if($reason != null){
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

    public function updateReasonOnCancelBtn(Request $request){

        Attendance::updateOrCreate([
            'user_grade_class_id' => $request->user_grade_class_id,
            'attendance_date' => $request->selectedDate,

        ],[
            'reason' => $request->reason,
        ]);

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

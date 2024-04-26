<?php

use App\Http\Controllers\AcadamicYearController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamMarkController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PromoteController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControlller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Contracts\Role;

// login, register
Route::get('login',[AuthController::class,'loginPage'])->name('loginPage');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('register',[AuthController::class,'registerPage'])->name('registerPage');
Route::post('register',[AuthController::class,'register'])->name('register');

Route::middleware(['auth'])->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');


    Route::middleware(['role:admin'])->group(function () {

        // acadamic year
        Route::get('academic-year/index',[AcadamicYearController::class,'index'])->name('academic-years.index');
        Route::get('academic-year/getCalendarInfo/{id}',[AcadamicYearController::class,'getCalendarInfo'])->name('academic-years.get.calendar.info');
        Route::post('academic-year/store',[AcadamicYearController::class,'store'])->name('academic-years.store');
        Route::post('academic-year/edit',[AcadamicYearController::class,'update'])->name('academic-years.edit');
        Route::get('academic-year/destroy/{id}',[AcadamicYearController::class,'destroy'])->name('academic-years.destroy');

        // holidays
        Route::get('holidays/index',[HolidayController::class,'index'])->name('holidays.index');
        Route::post('holidays/store',[HolidayController::class,'store'])->name('holidays.store');
        Route::post('holidays/edit',[HolidayController::class,'update'])->name('holidays.edit');
        Route::get('holidays/destroy/{id}',[HolidayController::class,'destroy'])->name('holidays.destroy');

        // grades
        Route::get('grades/modify',[GradeController::class,'modify'])->name('grades.modify');
        Route::get('/grade/{grade}/classes', [GradeController::class,'showClasses'])->name('grades.classes');
        Route::get('/grade/classes/registration/{gradeId}/{classId}',[GradeController::class,'showRegistrations'])->name('grades.classes.show.registrations');
        Route::resource('grades',GradeController::class);

        // classes
        Route::get('classes/modify',[ClassesController::class,'modify'])->name('classes.modify');
        Route::get('create/class/{gradeIdParameter?}',[ClassesController::class,'createNewClass'])->name('classes.createNewClass');
        Route::resource('classes',ClassesController::class);

        // user management
        Route::get('users/filter/{user_type}',[UserController::class,'filterUser'])->name('users.filter');
        Route::get('users/modify',[UserController::class,'modify'])->name('users.modify');
        Route::resource('users',UserController::class);

        // curriculums
        Route::get('curricula/filter/{filter_type}',[CurriculumController::class,'filterCurriculum'])->name('curricula.filter');
        Route::get('curricula/modify',[CurriculumController::class,'modify']);
        Route::post('curricula/updatedata',[CurriculumController::class,'updateData'])->name('curricula.updateData');
        Route::get('/curricula/max-id', [CurriculumController::class, 'getMaxId'])->name('curricula.getMaxId');
        Route::get('curricula/delete/all/grade/{gradeId}',[CurriculumController::class,'curriculumDeleteWithGrade'])->name('curricula.delete.with.grade');
        Route::resource('curricula',CurriculumController::class);

    });

    Route::middleware(['role:admin|subject teacher|student'])->group(function () {
        // class work
        Route::get('classwork/search',[ClassworkController::class,'search'])->name('classworks.search');
        Route::post('classwork/list',[ClassworkController::class,'searchResults'])->name('classworks.search_results');
        Route::get('classworks/max-id', [ClassworkController::class,'getMaxId'])->name('classworks.getMaxId');
        Route::post('classworks/updatedata',[ClassworkController::class,'updateData'])->name('classworks.updateData');

        Route::get('classworks/delete/with/{subTopicName}',[ClassworkController::class,'deleteWithSubTopicName'])->name('classworks.delete.with.subTopicName');
        Route::resource('classworks',ClassworkController::class);
    });





    // Route::get('classworks/delete/with/{subTopicName}',function(){
    //     Log::info('hello world ');
    // })->name('classworks.delete.with.subTopicName');



    Route::middleware(['role:admin|class teacher'])->group(function () {
        // attendances
        // Route::get('mark-attendance',[AttendanceController::class,'markAttendance'])->name('mark.attendance');

        // mark attendance
        Route::get('mark-attendances-search',[AttendanceController::class,'search'])->name('attendances.mark.search');

        Route::post('attendances/search-results',[AttendanceController::class,'searchResults'])->name('attendances.search_results');

        // view attendance report
        Route::get('report-attendances-search',[AttendanceController::class,'search'])->name('attendances.report.search');
        Route::post('attendances/view-report',[AttendanceController::class,'viewReport'])->name('attendances.view_report');

        Route::get('attendances/view-report/{month}',[AttendanceController::class,'percentagePerMonth'])->name('attendances.view-report.per.month');
        Route::get('attendances/details',[AttendanceController::class,'attendanceDetails'])->name('attendances.details');
        Route::get('attendances/get-by-date',[AttendanceController::class,'attendanceByDate'])->name('attendances.get-by-date');
        Route::get('attendances/get-by-date-mark-attendance',[AttendanceController::class,'attendanceByDateInMarkAttendance'])->name('attendances.getByDate.in.mark.attendance');
        Route::post('attedances/update-reason-on-cancel-btn',[AttendanceController::class,'updateReasonOnCancelBtn'])->name('attendances.update.reason.on.cancel.btn');
        // Route::get('attendances/get-by-date',[AttendanceController::class,'attendanceByDateInMarkAttendance'])->name('attendances.getByDate.in.mark.attendance');

        Route::resource('attendances',AttendanceController::class);

        // promote student
        Route::get('promote/search',[PromoteController::class,'searchGradeClass'])->name('promote.search');
        Route::post('promote/search/results',[PromoteController::class,'searchResults'])->name('promote.search.results');
        Route::post('promote/student',[PromoteController::class,'promoteStudent'])->name('promote.student');

        // time table
        Route::get('timetable/list',[TimetableController::class,'list'])->name('timetables.list');
        Route::get('timetable/new',[TimetableController::class,'addNewTimeTable'])->name('timetables.new');
        Route::post('timetable/store',[TimetableController::class,'store'])->name('timetable.store');
        Route::get('timetable/edit',[TimetableController::class,'edit'])->name('timetables.edit');
        Route::post('timetable/update',[TimetableController::class,'update'])->name('timetables.update');
        Route::get('timetable/destroy/{gradeId}/{classId}',[TimetableController::class,'destroy'])->name('timetables.destroy');
        Route::get('get-file-name',[TimetableController::class,'getTimetableFileName'])->name('timetables.get.file.name');

        // Route::get('exam-marks/search',[ExamMarkController::class,''])
        Route::get('exam-marks/search',[ExamMarkController::class,'addNewExamMark'])->name('exam-marks.search');
        Route::post('exam-marks/search/results',[ExamMarkController::class,'searchResults'])->name('exam-marks.search.results');
        Route::post('exam-marks/store',[ExamMarkController::class,'store'])->name('exam-marks.store');
        Route::get('exam-marks/edit',[ExamMarkController::class,'edit'])->name('exam-marks.edit');

        Route::post('exam-marks/update',[ExamMarkController::class,'update'])->name('exam-marks.update');
        Route::get('exam-marks/destroy/{gradeId}/{classId}',[ExamMarkController::class,'destroy'])->name('exam-marks.destroy');

        Route::get('exam-marks/subjects',[ExamMarkController::class,'allExamSubjects'])->name('exam-marks.subjects');


        Route::get('exam-marks/subject/new',[ExamMarkController::class,'getExamSubject'])->name('exam-marks.subject');
        Route::post('exam-marks/save/subjects',[ExamMarkController::class,'saveExamSubject'])->name('exam-marks.save-subject');

        // Route::post()

    });




});

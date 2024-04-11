<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\PromoteController;
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

    Route::middleware(['role:admin|subject teacher'])->group(function () {
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

        Route::resource('attendances',AttendanceController::class);

        // promote student
        Route::get('promote/search',[PromoteController::class,'searchGradeClass'])->name('promote.search');
        Route::post('promote/search/results',[PromoteController::class,'searchResults'])->name('promote.search.results');
        Route::post('promote/student',[PromoteController::class,'promoteStudent'])->name('promote.student');
    });


});

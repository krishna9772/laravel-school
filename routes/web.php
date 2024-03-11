<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserControlller;
use Illuminate\Support\Facades\Route;


// login, register
Route::get('login',[AuthController::class,'loginPage'])->name('loginPage');
Route::post('login',[AuthController::class,'login'])->name('login');
Route::get('register',[AuthController::class,'registerPage'])->name('registerPage');
Route::post('register',[AuthController::class,'register'])->name('register');

Route::middleware(['auth'])->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::post('logout',[AuthController::class,'logout'])->name('logout');

    // grades
    Route::get('grades/modify',[GradeController::class,'modify'])->name('grades.modify');
    Route::get('/grade/{grade}/classes', [GradeController::class,'showClasses'])->name('grades.classes');
    Route::resource('grades',GradeController::class);

    // classes
    Route::get('classes/modify',[ClassesController::class,'modify'])->name('classes.modify');
    Route::resource('classes',ClassesController::class);

    // user management
    Route::get('users/filter/{user_type}',[UserController::class,'filterUser'])->name('users.filter');
    Route::get('users/modify',[UserController::class,'modify'])->name('users.modify');
    Route::get('search',[UserController::class,'search'])->name('users.search');
    Route::resource('users',UserController::class);

    // curriculums
    Route::get('curricula/filter/{filter_type}',[CurriculumController::class,'filterCurriculum'])->name('curricula.filter');
    Route::get('curricula/modify',[CurriculumController::class,'modify']);
    Route::post('curricula/updatedata',[CurriculumController::class,'updateData'])->name('curricula.updateData');
    Route::get('/curricula/max-id', [CurriculumController::class, 'getMaxId'])->name('curricula.getMaxId');
    Route::get('curricula/delete/all/grade/{gradeId}',[CurriculumController::class,'curriculumDeleteWithGrade'])->name('curricula.delete.with.grade');
    Route::resource('curricula',CurriculumController::class);

    // class work
    Route::get('search',[ClassworkController::class,'search'])->name('classworks.search');
    Route::post('search-results',[ClassworkController::class,'searchResults'])->name('classworks.search_results');
    Route::resource('classworks',ClassworkController::class);



});

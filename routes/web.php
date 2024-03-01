<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['guest'])->group(function () {
    Route::get('login',[AuthController::class,'loginPage'])->name('loginPage');
    Route::post('login',[AuthController::class,'login'])->name('login');
    Route::get('register',[AuthController::class,'registerPage'])->name('registerPage');
    Route::post('register',[AuthController::class,'register'])->name('register');
});

Route::middleware(['auth'])->group(function(){});

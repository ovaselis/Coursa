<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;

Route::resource('courses', CourseController::class); //Crud routes for courses
Route::resource('courses.lectures', LectureController::class); //Crud routes for lectures

Route::get('/', function () {
    return view('welcome');
});

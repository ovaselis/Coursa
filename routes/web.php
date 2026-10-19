<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\NoteController;

Route::resource('courses', CourseController::class); //Crud routes for courses
Route::resource('courses.lectures', LectureController::class); //Crud routes for lectures
Route::resource('courses.lectures.notes', NoteController::class);  //Crud routes for notes

Route::get('/', function () {
    return view('welcome');
});

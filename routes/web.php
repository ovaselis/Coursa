<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

Route::resource('courses', CourseController::class); //Crud routes for courses

Route::get('/', function () {
    return view('welcome');
});

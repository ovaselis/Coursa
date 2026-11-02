<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FlashcardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('courses.lectures', LectureController::class);
    Route::resource('courses.lectures.notes', NoteController::class);
    Route::resource('courses.calendar-events', CalendarEventController::class);
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar/events', [CalendarController::class, 'storeEvent'])
    ->name('calendar.events.store');

    Route::get('/ollama-test', [FlashcardController::class, 'testOllama'])
    ->name('ollama.test');


    Route::post('/notes/{note}/flashcards/generate',[FlashcardController::class, 'generate'])->name('flashcards.generate');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

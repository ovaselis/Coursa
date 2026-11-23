<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\FlashcardController;
use App\Http\Controllers\TaskController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()){ return redirect()->route('dashboard');}

    return view('welcome');
});

//dashboard

Route::get('/dashboard', function () {
    return view('index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('courses', CourseController::class);
    Route::resource('courses.lectures', LectureController::class);
    Route::resource('courses.lectures.notes', NoteController::class);
    Route::resource('courses.calendar-events', CalendarEventController::class);

    //calendar events
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar/events', [CalendarController::class, 'storeEvent'])
    ->name('calendar.events.store');
    Route::put('/calendar/events/{type}/{id}', [CalendarController::class, 'updateEvent'])
    ->name('calendar.events.update');
    Route::put('/calendar/events/{type}/{id}', [CalendarController::class, 'destroyEvent'])
    ->name('calendar.events.destroy');

    //tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

    //flashcards
    Route::post('/notes/{note}/flashcards/generate',[FlashcardController::class, 'generate'])
    ->name('flashcards.generate');
    Route::get('/flashcards', [FlashcardController::class, 'index'])
    ->name('flashcards.index');
    Route::get('notes/{note}/flashcards', [FlashcardController::class, 'show'])
    ->name('flashcards.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

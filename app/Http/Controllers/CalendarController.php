<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\Assessment;
use App\Models\ScheduledLecture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        
        $month = $request->input('month', now()->format('Y-m')); //gets month from url or uses the current month

        $currentMonth = Carbon::createFromFormat('Y-m', $month)
        ->startOfMonth(Carbon::MONDAY); // creates a carbon date for the first day of the month

        $calendarStart = $currentMonth->copy()->startOfWeek(Carbon::MONDAY); //first visable day in the calendar

        $calendarEnd = $currentMonth->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY); //last visable day in the calendar

        $tasks = Task::whereHas('course', function($query){
            $query->where('user_id', auth()->id());
        })
        ->whereBetween('deadline', [$calendarStart, $calendarEnd])
        ->orderBy('deadline')
        ->get();
       

        $assessments = Assessment::whereHas('course', function($query){
            $query->where('user_id', auth()->id());
        })
        ->whereBetween('date', [
            $calendarStart->toDateString(),
            $calendarEnd->toDateString()
        ])
        ->orderBy('date')
        ->get();

        $scheduledLectures = ScheduledLecture::whereHas('course', function($query){
            $query->where('user_id', auth()->id());
        })
        ->whereBetween('date', [
            $calendarStart->toDateString(),
            $calendarEnd->toDateString()
        ])
        ->orderBy('date')
        ->get();


        $courses = auth()->user()->courses; //passes users courses to calendar


        return view('calendar.index', compact('tasks', 'assessments', 'scheduledLectures' , 'currentMonth','calendarStart','calendarEnd', 'courses'));
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:lecture,task,assessment',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
        ]);
        //checks if the selected course belongs to the user
        $course = auth()->user()->courses()->findOrFail($validated['course_id']);

        if($validated['type'] === 'task'){
            
            Task::create([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'deadline' =>$validated['date'],
                'description' =>$validated['description'] ?? null,
                'link' =>$validated['link'] ?? null,
                'is_completed' => false,
            ]);

        }

        if($validated['type'] === 'assessment'){
            
            Assessment::create([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'date' =>$validated['date'],
                'description' =>$validated['description'] ?? null,
                'link' =>$validated['link'] ?? null,
            ]);

        }

        if($validated['type'] === 'lecture'){
            
            //Lecture meeds start and end time
            $request->validate([
                'start_time' => 'required',
                'end_time' => 'required|after:start_time'
            ])   ;

            ScheduledLecture::create([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'date' =>$validated['date'],
                'time_from' =>$validated['start_time'],
                'time_to' =>$validated['end_time'],
            ]);

        }



        return redirect()->route('calendar.index', ['month' => Carbon::parse($validated['date'])->format('Y-m')]);

    }



}

<?php

namespace App\Http\Controllers;
use App\Models\CalendarEvent;
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

        $events = CalendarEvent::whereHas('course', function ($query){
            $query->where('user_id', auth()->id()); // Only gets those events whose course nelongs to the authentificated user
        })
        ->whereBetween('starts_at', [$calendarStart, $calendarEnd]) // only those events who in the visable calendar
        ->orderBy('starts_at')
        ->get(); // executes the query and gets the events
       
        $events = $events->groupBy(function ($event) { // groups events by date
            return $event->starts_at->format('Y-m-d');
        });

        $courses = auth()->user()->courses; //passes users courses to calendar


        return view('calendar.index', compact('events','currentMonth','calendarStart','calendarEnd', 'courses')); //opens calendar and passes the selected events
    }

    public function storeEvent(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:lecture,task,assessment',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'nullable|after_or_equal:start_time',
        ]);
        //checks if the selected course belongs to the user
        $course = auth()->user()->courses()->findOrFail($validated['course_id']);

        $startsAt = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);

        $endsAt = null;

        if (!empty($validated['end_time'])) {
            $endsAt = Carbon::parse(
                $validated['date'] . ' ' . $validated['end_time']
            );
        }

        

        
        CalendarEvent::create([
            'course_id' => $course->id,
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'is_completed' => false,
        ]);



        return redirect()->route('calendar.index', ['month' => Carbon::parse($validated['date'])->format('Y-m')]);

    }



}

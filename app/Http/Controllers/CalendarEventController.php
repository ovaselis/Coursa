<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CalendarEventController;
use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use App\Models\Course;

class CalendarEventController extends Controller
{
    public function index(Course $course)
    {
        abort_if($course->user_id !== auth()->id(), 403);
        $events = $course->calendarEvents()
            ->orderBy('starts_at')
            ->get();
        
        return view('calendar-events.index', compact('course', 'events'));
    }

    public function create(Course $course)
    {
        abort_if($course->user_id !== auth()->id(), 403);
        return view('calendar-events.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        abort_if($course->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'type' => 'required|in:lecture,task,assessment',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);

        $validated['course_id'] = $course->id;

        CalendarEvent::create($validated);

        return redirect()->route('courses.calendar-events.index', $course);
    }

    public function show(Course $course, CalendarEvent $calendarEvent)
    {
        abort_if($course->user_id !== auth()->id(), 403);
        abort_if($calendarEvent->course_id !== $course->id, 404);

        return view('calendar-events.show',compact('course', 'calendarEvent'));
    }

    public function edit(Course $course, CalendarEvent $calendarEvent)
    {

        abort_if($course->user_id !== auth()->id(), 403);
        abort_if($calendarEvent->course_id !== $course->id, 404);

        return view('calendar-events.edit', compact('course', 'calendarEvent'));
    }

    public function update(Request $request, Course $course, CalendarEvent $calendarEvent)
    {
        abort_if($course->user_id !== auth()->id(), 403);
        abort_if($calendarEvent->course_id !== $course->id, 404);

        $validated = $request->validate([
            'type' => 'required|in:lecture,task,assessment',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'is_completed' => 'nullable|boolean',

            

        ]);

        $calendarEvent->update($validated);

        return redirect()->route('courses.calendar-events.show',[$course, $calendarEvent]);



    }

    public function destroy(Course $course, CalendarEvent $calendarEvent)
    {
        abort_if($course->user_id !== auth()->id(), 403);
        abort_if($calendarEvent->course_id !== $course->id, 404);

        $calendarEvent->delete();

        return redirect()->route('courses.calendar-events.index', $course);
    }
}

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

        $tasks = Task::whereHas('course', function($query){ //gets users tasks for the open calendar period
            $query->where('user_id', auth()->id());
        })
        ->whereBetween('deadline', [$calendarStart, $calendarEnd])
        ->orderBy('deadline')
        ->get();
       

        $assessments = Assessment::whereHas('course', function($query){ //gets users assessments for the open calendar period
            $query->where('user_id', auth()->id());
        })
        ->whereBetween('date', [
            $calendarStart->toDateString(),
            $calendarEnd->toDateString()
        ])
        ->orderBy('date')
        ->get();

        $scheduledLectures = ScheduledLecture::whereHas('course', function($query){ //gets users lectures for the open calendar period
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

            //for scheduled recurring lectures

            'recurring' => 'nullable|boolean',
            'repeat_until' => 'nullable|date|after_or_equal:date',
            'recurring_days' => 'nullable|array',
        ]);
        //checks if the selected course belongs to the user
        $course = auth()->user()->courses()->findOrFail($validated['course_id']);


        //creates new task
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
        //creates new assessment
        if($validated['type'] === 'assessment'){
            
            Assessment::create([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'date' =>$validated['date'],
                'description' =>$validated['description'] ?? null,
                'link' =>$validated['link'] ?? null,
            ]);

        }
        //creates new tlecture
        if($validated['type'] === 'lecture'){
            
            if($request->boolean('recurring')){ //recurring lectures

                $request->validate([
                    'repeat_until' => 'required|date|after_or_equal:date',
                    'recurring_days' => 'required|array|min:1',
                ]);

                $currentDate = Carbon::parse($validated['date']);
                $repeatUntil = Carbon::parse($validated['repeat_until']);

                while($currentDate->lte($repeatUntil)){ // goes through every date until the repeat end date

                    $dayName = strtolower($currentDate->format('l')); //gets the days name
                    
                    if (isset($validated['recurring_days'][$dayName])){ //checks if this is one of the days that was selected
                        $dayTimes = $validated['recurring_days'][$dayName];
                    
                        // creates lecture only if start and end times are set
                        if(!empty($dayTimes['start_time']) && !empty($dayTimes['end_time'])){
                            ScheduledLecture::create([
                                'course_id' => $course->id,
                                'title' => $validated['title'],
                                'date' =>$currentDate->toDateString(),
                                'time_from' => $dayTimes['start_time'],
                                'time_to' =>$dayTimes['end_time'],
                            ]);

                            }

                    }
                    // goes to the next day

                    $currentDate->addDay();

                }

            }else{ // one time lecture

                //Lecture meeds start and end time
                $request->validate([
                    'start_time' => 'required',
                    'end_time' => 'required|after:start_time'
                ]);

                ScheduledLecture::create([
                    'course_id' => $course->id,
                    'title' => $validated['title'],
                    'date' =>$validated['date'],
                    'time_from' =>$validated['start_time'],
                    'time_to' =>$validated['end_time'],
                ]);
            }
        }


        // returns to the monthe in which the event
        return redirect()->route('calendar.index', ['month' => Carbon::parse($validated['date'])->format('Y-m')]);

    }

    public function updateEvent(Request $request, $type, $id)
    {
        //validates edited data
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|string',
            'date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',

        ]);
        //checks if the selected course belongs to the user
        $course = auth()->user()->courses()->findOrFail($validated['course_id']);

        if($type === 'task'){ //task update

            $task = Task::findOrFail($id);

            abort_if($task->course->user_id !== auth()->id(), 403);
            
            $task->update([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'deadline' =>$validated['date'],
                'description' =>$validated['description'] ?? null,
                'link' =>$validated['link'] ?? null,
            ]);

        }

        elseif($type === 'assessment'){ //assessment updatw
            
            $assessment = Assessment::findOrFail($id);

            abort_if($assessment->course->user_id !== auth()->id(), 403);

            $assessment->update([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'date' =>$validated['date'],
                'description' =>$validated['description'] ?? null,
                'link' =>$validated['link'] ?? null,
            ]);

        }

        elseif($type === 'lecture'){ //lecture update

            $request->validate([
                'start_time' => 'required',
                'end_time' => 'required|after:start_time'
            ]);

            $lecture = ScheduledLecture::findOrFail($id);

            abort_if($lecture->course->user_id !== auth()->id(), 403);

            $lecture->update([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'date' =>$validated['date'],
                'time_from' =>$validated['start_time'],
                'time_to' =>$validated['end_time'],
            ]);
            
        }else{
            abort(404);
        }


        //return to the event month
        return redirect()->route('calendar.index', ['month' => Carbon::parse($validated['date'])->format('Y-m')]);

    }

    public function destroyEvent($type, $id)
    {
        if($type === 'task'){
            $event = Task::findOrFail($id);
        }
        elseif($type === 'assessment'){
            $event = Assessment::findOrFail($id);
        }
        elseif($type === 'lecture'){
            $event = ScheduledLecture::findOrFail($id);
        }
        else{abort(404);}

        abort_if($event->course->user_id !== auth()->id(), 403);

        $event->delete();

        return redirect()->route('calendar.index');
    }



}

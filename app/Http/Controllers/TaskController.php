<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        Task::whereHas('course', function ($query) { //deletes outdated tasks
            $query->where('user_id', auth()->id());
        })
        ->whereDate('deadline', '<', today())
        ->delete();
        
        //gets all tasks for the athenticated user
        $tasks = Task::whereHas('course', function ($query){
                $query->where('user_id', auth()->id());
            })
            ->orderBy('deadline')
            ->get();

            $courses = auth()->user()->courses; //gets all courses for task creation dropdown select

            return view('tasks.index', compact('tasks', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'deadline' => 'required|date',
            'link' => 'nullable|string',
            'description' => 'nullable|string',       
        ]);
        //checks if selected course belongs to the authenticated user
        $course = auth()->user()->courses()->findOrFail($validated['course_id']);

        Task::create([ //new task creation
            'course_id' => $course->id,
            'title' => $validated['title'],
            'link' => $validated['link'] ?? null,
            'deadline' => Carbon::parse($validated['deadline']),
            'description' => $validated['description'] ?? null,
            'is_completed' => false,

        ]);

        return back();

    }

    public function toggle(Task $task)
    {
        abort_if($task->course->user_id !== auth()->id(), 403);

        $task->update([ //toggles completed / !completed for the tas
            'is_completed' => ! $task->is_completed,
        ]);

        return back();
    }

    public function edit(Task $task)
    {
        abort_if($task->course->user_id !== auth()->id(), 403);

        $courses = auth()->user()->courses;

        return view('tasks.edit', compact('task','courses'));


    }

    public function update(Request $request, Task $task)
    {
        abort_if($task->course->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'deadline' => 'required|date',
            'link' => 'nullable|string',
            'description' => 'nullable|string',       
        ]);

        $course = auth()->user()->courses()->findOrFail($validated['course_id']);
         //update task
        $task->update([
            'course_id' => $course->id,
            'title' => $validated['title'],
            'link' => $validated['link'] ?? null,
            'deadline' => Carbon::parse($validated['deadline']), //converts deadline to a carbon date object
            'description' => $validated['description'] ?? null,

        ]);

        return redirect()->route('tasks.index');

    }

    public function destroy(Task $task)
    {
        abort_if($task->course->user_id !== auth()->id(), 403);

        $task->delete();

        return redirect()->route('tasks.index');
    }

}

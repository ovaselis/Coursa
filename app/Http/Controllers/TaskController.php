<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        //gets all tasks for the athenticated user
        $tasks = Task::whereHas('course', function ($query){
                $query->where('user_id', auth()->id());
            })
            ->orderBy('deadline')
            ->get();

            $courses = auth()->user()->courses;

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

        $course = auth()->user()->courses()->findOrFail($validated['course_id']);

        Task::create([
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

        $task->update([
            'is_completed' => ! $task->is_completed,
        ]);

        return back();
    }
}

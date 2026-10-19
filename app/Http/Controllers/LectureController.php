<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{

    public function index(Course $course)
    {
        $lectures = $course->lectures;

        return view('lectures.index', compact('course', 'lectures'));
    }

    public function create(Course $course)
    {
        return view('lectures.create', compact('course'));
    }

    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'info' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $validated['course_id'] = $course->id;

        Lecture::create($validated);

        return redirect()->route('courses.show', $course);

    }

    public function show(Course $course, Lecture $lecture)
    {
        return view('lectures.show', compact('course', 'lecture'));
    }

    public function edit(Course $course, Lecture $lecture)
    {
        return view('lectures.edit',compact('course', 'lecture'));
    }

    public function update(Request $request, Course $course, Lecture $lecture)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'info' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        $lecture->update($validated);

        return redirect()->route('courses.lectures.show', [$course, $lecture]);
    }

    public function destroy(Course $course, Lecture $lecture)
    {
        $lecture->delete();
        return redirect()->route('courses.show', $course);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
  
    public function index()
    {
        $courses = Course::all(); // gets all the courses

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'official_url' => 'nullable|url|max:255',
            'lecturer' => 'nullable|string|max:255',
            'info' => 'nullable|string'
        ]);


        $validated['user_id'] = 1;

        Course::create($validated);

        return redirect()->route('courses.index');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit',compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'official_url' => 'nullable|url|max:255',
            'lecturer' => 'nullable|string|max:255',
            'info' => 'nullable|string'
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course);
    }


    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index');
    }
}

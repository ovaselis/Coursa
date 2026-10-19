<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Note;

class NoteController extends Controller
{

    public function index(Course $course, Lecture $lecture)
    {
        $notes = $lecture->notes;

        return view('notes.index', compact('course', 'lecture', 'notes'));
    }

    public function create(Course $course, Lecture $lecture)
    {
        return view('notes.create', compact('course', 'lecture'));
    }

    public function store(Request $request, Course $course, Lecture $lecture)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $validated['lecture_id'] = $lecture->id;

        Note::create($validated);

        return redirect()->route(
            'courses.lectures.show',
            [$course, $lecture]
        );
    }

    public function show(Course $course, Lecture $lecture, Note $note)
    {
        return view('notes.show', compact('course', 'lecture', 'note'));
    }

    public function edit(Course $course, Lecture $lecture, Note $note)
    {
        return view('notes.edit', compact('course', 'lecture', 'note'));
    }

    public function update(Request $request, Course $course, Lecture $lecture, Note $note)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($validated);

        return redirect()->route(
            'courses.lectures.notes.show',
            [$course, $lecture, $note]
        );
    }

    public function destroy(Course $course, Lecture $lecture, Note $note)
    {
        $note->delete();

        return redirect()->route(
            'courses.lectures.show',
            [$course, $lecture]
        );
    }
}

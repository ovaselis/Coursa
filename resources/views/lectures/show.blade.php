@extends('layouts.app')

@section('content')
{{--Returns to this lectures course page--}}
<a href=" {{ route('courses.show', $course) }} ">Back to course</a>

<h1>{{ $lecture->title }}</h1>

@if($lecture->date)
    <p>Date: {{ $lecture->date }}</p>
@endif

@if($lecture->info)
    <p>Info: {{ $lecture->info }}</p>
@endif
{{-- Opens the lecture edit page --}}
<a href=" {{ route('courses.lectures.edit', [$course, $lecture]) }} ">
    Edit lecture
</a>
{{-- Deletes the lecture--}}
<form method="POST" action="{{ route('courses.lectures.destroy', [$course, $lecture]) }}">
    @csrf
    @method('DELETE')

    <button type="submit">Delete lecture</button>
</form>

<h2>Notes</h2>

<a href="{{ route('courses.lectures.notes.create', [$course, $lecture]) }}">Add notes</a>
{{-- shows all notes of the lecture--}}
@foreach($lecture->notes as $note)
    <div>
        <a href="{{ route('courses.lectures.notes.show', [$course, $lecture, $note]) }}">{{ $note->title }}</a>

        <p>Last edited: {{ $note->updated_at->format('d.m.Y H:i') }}</p>
    </div>
@endforeach


@endsection

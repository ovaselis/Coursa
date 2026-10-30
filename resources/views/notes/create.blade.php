@extends('layouts.app')

@section('content')

<h1>Add note to {{ $lecture->title }}</h1>

<a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
    Back to lecture
</a>

<form method="POST" action="{{ route('courses.lectures.notes.store', [$course, $lecture]) }}">
    @csrf

    <div>
        <label for="title">Note title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title') }}"
        >
    </div>

    <x-editor :content="old('content')" />

    <button type="submit">Save note</button>
</form>
@endsection
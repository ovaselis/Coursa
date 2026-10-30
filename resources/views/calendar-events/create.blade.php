@extends('layouts.app')

@section('content')

<h1>Add calendar event</h1>

<form method="POST" action="{{ route('courses.calendar-events.store', $course) }}">

    csrf       

    <label>Type</label>
    <br>

    <select name="type">
        <option value="lecture">Lecture</option>
        <option value="task">Task</option>
        <option value="assessment">Assessment</option>
    </select>

    <br>
    <br>

    <label>Title</label>
    <br>

    <input
        type="text"
        name="title"
        value="{{ old('title') }}"
    >

    <br>
    <br>

    <label>Description</label>
    <br>

    <textarea name="description">{{ old('description') }}</textarea>

    <br>
    <br>

    <label>Starts at</label>
    <br>

    <input
        type="datetime-local"
        name="starts_at"
        value="{{ old('starts_at') }}"
    >

    <br>
    <br>

    <label>Ends at</label>
    <br>

    <input
        type="datetime-local"
        name="ends_at"
        value="{{ old('ends_at') }}"
    >

    <br>
    <br>

    <button type="submit">Create event</button>

</form>
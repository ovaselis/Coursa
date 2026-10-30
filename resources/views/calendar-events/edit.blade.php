@extends('layouts.app')

@section('content')

<h1>Edit calendar event</h1>

<form
    method="POST"
    action="{{ route('courses.calendar-events.update', [$course, $calendarEvent]) }}"
>

    @csrf
    @method('PUT')

    <label>Type</label>
    <br>

    <select name="type">

        <option
            value="lecture"
            @selected(old('type', $calendarEvent->type) === 'lecture')
        >
            Lecture
        </option>

        <option
            value="task"
            @selected(old('type', $calendarEvent->type) === 'task')
        >
            Task
        </option>

        <option
            value="assessment"
            @selected(old('type', $calendarEvent->type) === 'assessment')
        >
            Assessment
        </option>

    </select>

    <br>
    <br>

    <label>Title</label>
    <br>

    <input
        type="text"
        name="title"
        value="{{ old('title', $calendarEvent->title) }}"
    >

    <br>
    <br>

    <label>Description</label>
    <br>

    <textarea name="description">{{ old('description', $calendarEvent->description) }}</textarea>

    <br>
    <br>

    <label>Starts at</label>
    <br>

    <input
        type="datetime-local"
        name="starts_at"
        value="{{ old('starts_at', $calendarEvent->starts_at->format('Y-m-d\TH:i')) }}"
    >

    <br>
    <br>

    <label>Ends at</label>
    <br>

    <input
        type="datetime-local"
        name="ends_at"
        value="{{ old('ends_at', $calendarEvent->ends_at?->format('Y-m-d\TH:i')) }}"
    >

    <br>
    <br>

    @if($calendarEvent->type === 'task')

        <input
            type="hidden"
            name="is_completed"
            value="0"
        >

        <input
            type="checkbox"
            name="is_completed"
            value="1"
            @checked(old('is_completed', $calendarEvent->is_completed))
        >

        <label>Completed</label>

        <br>
        <br>

    @endif

    <button type="submit">
        Save
    </button>

</form>

<br>

<a href="{{ route('courses.calendar-events.show', [$course, $calendarEvent]) }}">
    Back
</a>

@endsection
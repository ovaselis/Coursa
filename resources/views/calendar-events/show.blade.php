@extends('layouts.app')

@section('content')

<h1>{{ $calendarEvent->title }}</h1>

<p>Type: {{ $calendarEvent->type }}</p>

<p>
    Starts:
    {{ $calendarEvent->starts_at->format('d.m.Y H:i') }}
</p>

@if($calendarEvent->ends_at)
    <p>
        Ends:
        {{ $calendarEvent->ends_at->format('d.m.Y H:i') }}
    </p>
@endif

@if($calendarEvent->description)
    <p>
        Description:
        {{ $calendarEvent->description }}
    </p>
@endif

@if($calendarEvent->type === 'task')
    <p>
        Completed:
        {{ $calendarEvent->is_completed ? 'Yes' : 'No' }}
    </p>
@endif

<a href="{{ route('courses.calendar-events.edit', [$course, $calendarEvent]) }}">
    Edit
</a>

<br>
<br>

<form
    method="POST"
    action="{{ route('courses.calendar-events.destroy', [$course, $calendarEvent]) }}"
>
    @csrf
    @method('DELETE')

    <button type="submit">Delete</button>
</form>

<br>

<a href="{{ route('courses.calendar-events.index', $course) }}">
    Back
</a>

@endsection
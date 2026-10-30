@extends('layouts.app')

@section('content')

<h1>Calendar events</h1>

<a href="{{ route('courses.calendar-events.create', $course) }}">
    Add event
</a>

<br>
<br>

@foreach($events as $event)

    <a href="{{ route('courses.calendar-events.show', [$course, $event]) }}">
        {{ $event->title }}
    </a>

    <br>

    {{ $event->type }}

    <br>

    {{ $event->starts_at->format('d.m.Y H:i') }}

    <br>
    <br>

@endforeach

<a href="{{ route('courses.show', $course) }}">
    Back to course
</a>

@endsection
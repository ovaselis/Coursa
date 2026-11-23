@extends('layouts.app')

@section('content')

<h1>Lectures - {{ $course->name }}</h1>
{{-- Back to courses page --}}
<a href="{{ route('courses.show', $course) }}">Back to course</a>
{{-- Opens form for new lecture --}}
<a href="{{ route('courses.lectures.create', $course) }}">
    Add lecture
</a>
{{ Shows all lectures belonging to the course}}
@foreach($lectures as $lecture)

    <div>
        {{-- Opens selected lecture --}}
        <a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
            {{ $lecture->title }}
        </a>

        @if($lecture->date)
            <p>{{ $lecture->date }}</p>
        @endif
    </div>

@endforeach

@endsection
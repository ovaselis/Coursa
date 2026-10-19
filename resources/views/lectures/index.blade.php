<h1>Lectures - {{ $course->name }}</h1>

<a href="{{ route('courses.show', $course) }}">Back to course</a>

<a href="{{ route('courses.lectures.create', $course) }}">
    Add lecture
</a>

@foreach($lectures as $lecture)

    <div>
        <a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
            {{ $lecture->title }}
        </a>

        @if($lecture->date)
            <p>{{ $lecture->date }}</p>
        @endif
    </div>

@endforeach
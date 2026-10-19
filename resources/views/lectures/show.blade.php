<a href="{{ route('courses.show', $course) }}">Back to course</a>

<h1>{{ $lecture->title }}</h1>

@if($lecture->date)
    <p>Date: {{ $lecture->date }}</p>
@endif

@if($lecture->info)
    <p>Info: {{ $lecture->info }}</p>
@endif

<a href="{{ route('courses.lectures.edit', [$course, $lecture]) }}">
    Edit lecture
</a>

<form method="POST" action="{{ route('courses.lectures.destroy', [$course, $lecture]) }}">
    @csrf
    @method('DELETE')

    <button type="submit">Delete lecture</button>
</form>
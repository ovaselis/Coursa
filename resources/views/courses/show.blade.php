<a href="{{ route('courses.index') }}">Back</a>

<h1>{{ $course->name }}</h1>

@if($course->lecturer)
    <p>Lecturer: {{ $course->lecturer }}</p>
@endif

@if($course->official_url)
    <p>Page: {{ $course->official_url }}</p>
@endif

@if($course->info)
    <p>Info: {{ $course->info }}</p>
@endif

<br>

<a href="{{ route('courses.edit', $course) }}">Edit course</a>

<form method="POST" action="{{ route('courses.destroy', $course) }}">
    @csrf 
    @method('DELETE')

    <button type="submit">Delete course</button>
</form>

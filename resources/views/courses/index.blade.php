<h1> Courses </h1>

<a href="{{ route('courses.create') }}">Add a course</a>

<br>
<br>

@foreach($courses as $course)

    <a href="{{ route('courses.show', $course) }}">
    {{ $course->name }} 
    </a>

    <br>
    <br>

@endforeach
<h1> Courses </h1>

<a href="{{ route('courses.create') }}">Pievienot kursu</a>

@foreach($courses as $course)
    <p>{{ $course->name }}</p>
@endforeach
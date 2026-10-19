<h1>Notes - {{ $lecture->title }}</h1>

<a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
    Back to lecture
</a>

<a href="{{ route('courses.lectures.notes.create', [$course, $lecture]) }}">
    Add note
</a>

@foreach($notes as $note)

    <div>
        <a href="{{ route('courses.lectures.notes.show', [$course, $lecture, $note]) }}">
            {{ $note->title }}
        </a>

        <p>
            Last edited:
            {{ $note->updated_at->format('d.m.Y H:i') }}
        </p>
    </div>

@endforeach
<a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
    Back to lecture
</a>

<h1>{{ $note->title }}</h1>

<p>
    Last edited:
    {{ $note->updated_at->format('d.m.Y H:i') }}
</p>

<div>
    {!! Illuminate\Support\Str::markdown($note->content) !!}
</div>

<a href="{{ route('courses.lectures.notes.edit', [$course, $lecture, $note]) }}">
    Edit note
</a>

<form method="POST" action="{{ route('courses.lectures.notes.destroy', [$course, $lecture, $note]) }}">
    @csrf
    @method('DELETE')

    <button type="submit">Delete note</button>
</form>
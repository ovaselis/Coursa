<h1>Add note to {{ $lecture->title }}</h1>

<a href="{{ route('courses.lectures.show', [$course, $lecture]) }}">
    Back to lecture
</a>

<form method="POST" action="{{ route('courses.lectures.notes.store', [$course, $lecture]) }}">
    @csrf

    <div>
        <label for="title">Note title</label>
        <input
            type="text"
            name="title"
            id="title"
            value="{{ old('title') }}"
        >
    </div>

    <div>
        <label for="content">Content</label>
        <textarea
            name="content"
            id="content"
            rows="20"
        >{{ old('content') }}</textarea>
    </div>

    <button type="submit">Save note</button>
</form>